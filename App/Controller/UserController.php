<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\HTML\TemplateForm;

class UserController extends Controller
{
    public function login()
    {
        $this->template = 'user';
        $userService = $this->services->getService('user');
        $form = new TemplateForm($_POST);
        $fb = $this->request->get('login/loginfb');

        if($userService->islogged()){
            $this->denied();
        }

        if (isset($fb)) {
            $url = $this->services->getService('facebook')->getUrlLoginFacebook(['email']);
            header('Location: ' . $url);
        }

        if('POST' === $this->request->getMethod()) {
            $email = $this->request->get('email');
            $password = $this->request->get('password');
            if ($userService->login($email, $password)) {
                $this->redirect('user_profil');
            }
            $this->addFlashBag('login.bad.password', 'danger');
        }

        $this->render('user/login', compact('form'));
    }

    public function loginfb()
    {
        $userService = $this->services->getService('user');

        if ($this->request->get('code')) {
            $profil = $userService->getProfilFacebook();

            if (!$userService->loginfb($profil->getEmail(), $profil->getId())) {
                $error = $userService->register($profil->getEmail(), $profil->getId(), $profil->getId(), $profil->getLastName() , $profil->getFirstName(), null, null, $profil->getId());
                $this->addFlashBag($error[0], $error[1]);
                if (!$error[2]) {
                    $this->template = 'user';
                    $form = new TemplateForm($_POST);
                    $this->render('user/login', compact('form'));
                    die;
                }
                $userService->login($profil->getEmail(), $profil->getId(), true);
            }
            $this->redirect('user_profil');
        }
    }

    public function register()
    {
        $this->template = 'user';
        $userService = $this->services->getService('user');
        
        if($userService->islogged()){
            $this->denied();
        }

        if('POST' === $this->request->getMethod()) {
            $email = $this->request->get('email');
            $name = $this->request->get('name');
            $firstname = $this->request->get('firstname');
            $password = $this->request->get('password');
            $password_verif = $this->request->get('password_verif');
            $country = $this->services->getRepository('')->find($this->request->get('country'));
            $zip = $this->request->get('zip');
            $error = $userService->register($email, $password, $password_verif, $name, $firstname, $country, $zip);
            $this->addFlashBag($error[0], $error[1]);
        }

        $countries = $this->services->getRepository('country')->findAll();
        $form = new TemplateForm($_POST);
        $this->render('user/register', compact('form', 'countries'));
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_id']);
        $this->redirect('index');
    }

    public function profil()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        $userRepo = $this->services->getRepository('user');

        $this->render('user/profil', compact('user'));
    }

    public function adverts()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        $advertRepo = $this->services->getRepository('advert');
        $advertService = $this->services->getService('advert');
        $adverts = $advertRepo->findBy(['user' => $user]);

        if('POST' === $this->request->getMethod()) {
            if ($this->request->get('delete')) {
                $advert = $advertRepo->find($this->request->get('delete'));
                if ($advert->getUser() === $user) {
                    $advertService->delete($advert);
                    die;
                }
            }
            if ($this->request->get('locked')) {
                $advert = $advertRepo->find($this->request->get('locked'));
                if ($advert->getUser() === $user) {
                    $advertService->lock($advert);
                    die;
                }
            }
        }

        $this->render('user/adverts', compact('adverts'));
    }

    public function bookmarks()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        $bookmarksRepo = $this->services->getRepository('bookmark');
        $bookmarks = $bookmarksRepo->findBy(['user' => $user]);

        $this->render('user/bookmarks', compact('bookmarks'));
    }

    public function transactions()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        $transactionRepo = $this->services->getRepository('transaction');

        if('POST' === $this->request->getMethod()) {
            $message = $this->request->get('message');
            $rating = round($this->request->get('rate'));
            $transaction = $transactionRepo->find($this->request->get('transaction'));

            if ($transaction->getUser() === $user) {
                $this->services->getService('transaction')->setRating($transaction, $rating, $message);
                $this->addFlashBag('transaction.rate.success', 'success');
            }
        }

        $transactions = $transactionRepo->findBy(['user' => $user]);

        $this->render('user/transactions', compact('transactions'));
    }

    public function invoice(array $params)
    {
        if (isset($params['id'])) {
            $user = $this->getCurrentUser();

            $transaction = $this->services->getRepository('transaction')->find($params['id']);
            $contact = $this->services->getRepository('contact')->findOneBy(['user' => $user]);
            if ($transaction && $transaction->getUser() === $user) {
                $this->services->getService('pdf')->create('invoices/default', ['transaction' => $transaction, 'contact' => $contact]);
                die;
            }
        }
        $this->denied();
    }

    public function edit()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        if (isset($_GET['infos']) && !$user->isCompleted()) {
            $this->addFlashBag('profil.complet', 'danger');
        }

        if('POST' === $this->request->getMethod()) {
            $name = $this->request->get('name');
            $firstname = $this->request->get('firstname');
            $zip = $this->request->get('zip');
            $country = $this->services->getRepository('country')->find($this->request->get('country'));

            if ($country) {
                $this->services->getService('user')->edit($name, $firstname, (string) $zip, $country, $user);
                $this->addFlashBag('edit.profil.success', 'success');
            }
        }

        $countries = $this->services->getRepository('country')->findAll();
        $form = new TemplateForm();
        $this->render('user/edit', compact('user', 'form', 'countries'));
    }
}

<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\HTML\TemplateForm;


class UserController extends Controller
{
    public function login()
    {
        $this->template = 'user';
        $userRepo = $this->services->getRepository('user');
        $form = new TemplateForm($_POST);
        $fb = $this->request->get('login/loginfb');

        if($userRepo->islogged()){
            $this->denied();
        }

        if (isset($fb)) {
            $url = $this->services->getUrlLoginFacebook(['email']);
            header('Location: ' . $url);
        }

        if('POST' === $this->request->getMethod()) {
            $email = $this->request->get('email');
            $password = $this->request->get('password');
            if ($userRepo->login($email, $password)) {
                $this->redirect('user_profil');
            }
            $this->addFlashBag('login.bad.password', 'danger');
        }

        $this->render('user/login', compact('form'));
    }

    public function loginfb()
    {
        $userRepo = $this->services->getRepository('user');

        if ($this->request->get('code')) {
            $profil = $this->services->getProfilFacebook();

            if (!$userRepo->loginfb($profil->getEmail(), $profil->getId())) {
                $error = $userRepo->register($profil->getEmail(), $profil->getId(), $profil->getId(), $profil->getLastName() , $profil->getFirstName(), $profil->getId());
                $this->addFlashBag($error[0], $error[1]);
                if (!$error[2]) {
                    $this->template = 'user';
                    $form = new TemplateForm($_POST);
                    $this->render('user/login', compact('form'));
                    die;
                }
                $userRepo->login($profil->getEmail(), $profil->getId(), true);
            }
            $this->redirect('user_profil');
        }
    }

    public function register()
    {
        $this->template = 'user';
        $userRepo = $this->services->getRepository('user');
        
        if($userRepo->islogged()){
            $this->denied();
        }

        if('POST' === $this->request->getMethod()) {
            $email = $this->request->get('email');
            $name = $this->request->get('name');
            $firstname = $this->request->get('firstname');
            $password = $this->request->get('password');
            $password_verif = $this->request->get('password_verif');
            $error = $userRepo->register($email, $password, $password_verif, $name, $firstname);
            $this->addFlashBag($error[0], $error[1]);
        }

        $form = new TemplateForm($_POST);
        $this->render('user/register', compact('form'));
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
        $adverts = $advertRepo->findBy(['user' => $user]);

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
}
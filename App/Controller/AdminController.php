<?php

namespace App\Controller;

use App\Entity\Invoice;
use Core\Controller\Controller;

class AdminController extends Controller
{
    public function __construct(\AltoRouter $router)
    {
        parent::__construct($router);
        //if is not logged admin, then acces denied in env prod
        if (ENV !== 'dev') {
            if(!$this->twig->loggedAdmin()){
                $this->denied();
            }
        }
    }

    public function index()
    {
        $this->template = 'admin';
        $this->render('admin/index');
    }

    public function translations()
    {
        if('POST' === $this->request->getMethod()) {
            $translationsService = $this->services->getService('translations');
            $id = $this->request->get('id');
            $id_delete = $this->request->get('id_delete');
            $search = $this->request->get('search');

            if($id) {
                $name = $this->request->get('name');
                $fr = $this->request->get('fr');
                $en = $this->request->get('en');
                $translationsService->updateTranslation($id, $name, $fr, $en);
            }

            if($this->request->get('add')) {
                $name = $this->request->get('name');
                $fr = $this->request->get('fr');
                $en = $this->request->get('en');
                $translationsService->addTranslation($name, $fr, $en);
            }

            if($id_delete) {
                $translationsService->removeTranslation($id_delete);
            }

            if($search) {
                $translations = $this->services->getRepository('translations')->findTranslation($search);
                $this->template = 'disable';
                $this->render('admin/translations-data-display', compact('translations'));
                die;
            }
        }

        $this->template = 'admin';
        $this->render('admin/translations');
    }

    public function users()
    {
        $userRepo = $this->services->getRepository('user');
        $userService = $this->services->getService('user');
        $users = [];

        if('POST' === $this->request->getMethod()) {
            $id = $this->request->get('login');

            if(isset($id)) {
                $userService->loginAdmin($id);
                $this->redirect('index');
            }

            if($this->request->get('search')) {
                $name = $this->request->get('name');
                $email = $this->request->get('email');
                $id = $this->request->get('id');
                $users = $userRepo->search($name, $email, (int) $id);
            }
        }

        $this->template = 'admin';
        $this->render('admin/users', compact('users'));
    }

    public function relog()
    {
        $_SESSION['user_id'] = $_SESSION['edit_admin_id'];
        unset($_SESSION['edit_admin_id']);
        $this->redirect('index');
    }

    public function invoices()
    {
        $invoices = $this->services->getRepository('invoice')->findBy(['status' => Invoice::STATUS_CLEARED]);
        $this->template = 'admin';
        $this->render('admin/invoices', compact('invoices'));
    }
}

<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\HTML\TemplateForm;

class HomeController extends Controller
{
    public function index()
    {
        $str = 'Hello World';
        $advertRepo = $this->services->getRepository('advert');
        $userRepo = $this->services->getRepository('user');
        $advertsCategories = $advertRepo->findAllCategoryAdverts();
        $allAdverts = $advertRepo->findAll();
        $allRequests = [];
        $usersLocations = $userRepo->findAllPostcodeUsers();
        $allUsers = $userRepo->findAll();
        $premiumAdverts = $advertRepo->findBy([], ['id' => 'DESC'], 4, 0);

        $this->template = 'default';
        $this->title =  $this->twig->translation('home.page.title');
        $this->render('home/index', compact('str', 'advertsCategories', 'usersLocations', 'allAdverts', 'allRequests', 'allUsers', 'premiumAdverts'));
    }

    public function lang(array $params)
    {
        $referer = $this->request->server->get('HTTP_REFERER');
        if (!$params['id'] || !$referer) {
            $this->denied();
        }

        if ($params['id'] == 1) {
            $_SESSION['lang'] = 'fr';
        } elseif ($params['id'] == 2) {
            $_SESSION['lang'] = 'en';
        }

        header('Location: ' . $referer);
    }

    public function contact()
    {
        $this->template = 'home';
        $this->title = $this->twig->translation('home.page.contact');
        $form = new TemplateForm();

        $this->render('home/contact', compact('form'));
    }

    public function about()
    {
        $this->template = 'home';
        $this->render('home/about');
    }

    public function terms()
    {
        $this->template = 'home';
        $this->render('home/terms');
    }
}

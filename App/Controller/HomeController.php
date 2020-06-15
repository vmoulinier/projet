<?php

namespace App\Controller;

use Core\Controller\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $str = 'Hello World';

        $advertsCategories = $this->services->getRepository('advert')->findAllCategoryAdverts();
        $allAdverts = $this->services->getRepository('advert')->findAll();
        $allRequests = [];
        $usersLocations = $this->services->getRepository('user')->findAllPostcodeUsers();
        $allUsers = $this->services->getRepository('user')->findAll();
        $premiumAdverts = $this->services->getRepository('advert')->findBy([], ['id' => 'DESC'], 4, 0);

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
}

<?php

namespace App\Controller;

use App\Entity\Advert;
use Core\Controller\Controller;
use Core\HTML\TemplateForm;

class AdvertController extends Controller
{

    public function index()
    {
        $advertRepo = $this->services->getRepository('advert');
        $advertsCategories = $advertRepo->findAllCategoryAdverts();
        $usersLocations = $this->services->getRepository('user')->findAllPostcodeUsers();
        $adverts = $advertRepo->findBy(['status' => Advert::STATUS_ACTIVE]);

        if ('POST' === $this->request->getMethod()) {
            $limit = $this->request->get('limit');
            $start = $this->request->get('start');

            if (isset($limit, $start)) {

                if (!$this->request->get('search')) {
                    $adverts = $advertRepo->findBy(['status' => Advert::STATUS_ACTIVE], null, $limit, $start);
                }

                if ($this->request->get('search')) {
                    $name = $this->request->get('name');
                    $category = $this->request->get('category');
                    $location = $this->request->get('location');
                    $price = $this->request->get('price');
                    $adverts = $advertRepo->search($name, $category, $location, $price, $limit, $start);
                }

                $this->template = 'disable';
                $this->render('advert/advert-data-display', compact('adverts'));
                die;
            }
        }

        $this->template = 'advert';
        $this->title = $this->twig->translation('advert.page.title');
        $this->render('advert/index', compact('adverts', 'advertsCategories', 'usersLocations'));
    }

    public function viewadvert(array $params)
    {
        if (isset($params['id'])) {
            $advert = $this->services->getRepository('advert')->find($params['id']);

            if ($advert) {
                $advertService = $this->services->getService('advert');
                $advertService->setView($advert);
                if ('POST' === $this->request->getMethod()) {

                    if ($this->request->get('submitReview')) {
                        $message = $this->request->get('message');
                        $advertService->addQuestion($message, $advert, $this->getCurrentUser());
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('submitAnswer')) {
                        $message = $this->request->get('answer');
                        $questionId = $this->request->get('question_id');
                        $advertService->addAnswer($message, $questionId);
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('fav')) {
                        $advertService->addBookmark($advert, $this->getCurrentUser());
                    }
                }

                $pictures = $this->services->getRepository('picture')->findBy(['advert' => $advert]);
                $questions = $this->services->getRepository('question')->findBy(['advert' => $advert]);
                $this->template = 'default';
                $this->title = $advert->getTitle();
                $form = new TemplateForm();
                $this->render('advert/view', compact('advert', 'pictures', 'questions', 'form'));
            }
        }
        $this->denied();
    }

    public function create()
    {
        $this->template = 'user';
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        $advertService = $this->services->getService('advert');
        $expeditionRepo = $this->services->getRepository('expeditionType');
        $categoryRepo = $this->services->getRepository('category');

        if ('POST' === $this->request->getMethod()) {
            $title = $this->request->get('title');
            $category = $categoryRepo->find($this->request->get('category'));
            $price = $this->request->get('price');
            $description = $this->request->get('description');
            $brand = $this->request->get('brand');
            $shape = $this->request->get('shape');
            $purchasedat = new \DateTime($this->request->get('purchasedat'));
            $expeditiontype = $expeditionRepo->find($this->request->get('expeditiontype'));
            $guarantee = $this->request->get('guarantee');
            $advertService->create($title, $category, $user, $price, $description, $brand, $shape, $purchasedat, $expeditiontype, $guarantee);

            $this->addFlashBag('Success, but need to validate');
        }

        $form = new TemplateForm();
        $advertsCategories = $categoryRepo->findAll();
        $expeditionTypes = $expeditionRepo->findAll();

        $this->render('advert/create', compact('form', 'advertsCategories', 'expeditionTypes'));
    }

    public function edit(array $params)
    {
        if (isset($params['id'])) {
            $this->template = 'user';
            $user = $this->getCurrentUser();

            if(!$user){
                $this->redirect('user_login');
            }

            $advertRepo = $this->services->getRepository('advert');
            $advertService = $this->services->getService('advert');
            $categoryRepo = $this->services->getRepository('category');
            $pictureRepo = $this->services->getRepository('picture');
            $pictureService = $this->services->getService('picture');
            $advert = $advertRepo->find($params['id']);

            if ($advert && $advert->getUser() === $user) {
                $expeditionRepo = $this->services->getRepository('expeditionType');
                if ('POST' === $this->request->getMethod()) {
                    if ($this->request->get('submit')) {
                        $title = $this->request->get('title');
                        $category = $categoryRepo->find($this->request->get('category'));
                        $price = $this->request->get('price');
                        $description = $this->request->get('description');
                        $brand = $this->request->get('brand');
                        $shape = $this->request->get('shape');
                        $purchasedat = new \DateTime($this->request->get('purchasedat'));
                        $expeditiontype = $expeditionRepo->find($this->request->get('expeditiontype'));
                        $guarantee = $this->request->get('guarantee');
                        $advertService->update($advert, $title, $category, $user, $price, $description, $brand, $shape, $purchasedat, $expeditiontype, $guarantee);
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('rotation')) {
                        $rotation = $this->request->get('rotation');
                        $picture = $pictureRepo->find($this->request->get('img'));
                        $pictureService->rotate($picture, $rotation);
                    }

                    if ($this->request->get('delete')) {
                        $picture = $pictureRepo->find($this->request->get('delete'));
                        $pictureService->delete($picture);
                    }

                }

                $form = new TemplateForm();
                $advertsCategories = $categoryRepo->findAll();
                $expeditionTypes = $expeditionRepo->findAll();
                $pictures = $pictureRepo->findBy(['advert' => $advert]);
                $this->render('advert/edit', compact('form', 'advertsCategories', 'expeditionTypes', 'advert', 'pictures'));
            }
        }
        $this->denied();
    }
}

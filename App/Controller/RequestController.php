<?php

namespace App\Controller;

use App\Entity\Advert;
use Core\Controller\Controller;
use Core\HTML\TemplateForm;

class RequestController extends Controller
{

    public function index()
    {
        $advertRepo = $this->services->getRepository('advert');
        $advertsCategories = $advertRepo->findAllCategoryAdverts();
        $usersLocations = $this->services->getRepository('user')->findAllPostcodeUsers();
        $requests = $advertRepo->findBy(['status' => Advert::STATUS_ACTIVE, 'type' => 2], ['id' => 'DESC']);

        if ('POST' === $this->request->getMethod()) {
            $limit = $this->request->get('limit');
            $start = $this->request->get('start');

            if (isset($limit, $start)) {

                if (!$this->request->get('search')) {
                    $requests = $advertRepo->findBy(['status' => Advert::STATUS_ACTIVE, 'type' => 2],  ['id' => 'DESC'], $limit, $start);
                }

                if ($this->request->get('search')) {
                    $name = $this->request->get('name');
                    $category = $this->request->get('category');
                    $location = $this->request->get('location');
                    $price = $this->request->get('price');
                    $requests = $advertRepo->search($name, $category, $location, $price, $limit, $start, 2);
                }

                $this->template = 'disable';
                $this->render('request/request-data-display', compact('requests'));
                die;
            }
        }

        $this->template = 'advert';
        $this->title = $this->twig->translation('advert.page.title');
        $this->render('request/index', compact('requests', 'advertsCategories', 'usersLocations'));
    }

    public function viewrequest(array $params)
    {
        if (isset($params['id'])) {
            $request = $this->services->getRepository('advert')->find($params['id']);

            if ($request) {
                $advertService = $this->services->getService('advert');
                $advertService->setView($request);
                $user = $this->getCurrentUser();

                if ('POST' === $this->request->getMethod()) {

                    if ($this->request->get('submitReview') && $user) {
                        $message = $this->request->get('message');
                        $advertService->addQuestion($message, $request, $user);
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('submitAnswer') && ($user === $request->getUser())) {
                        $message = $this->request->get('answer');
                        $questionId = $this->request->get('question_id');
                        $advertService->addAnswer($message, $questionId);
                        $this->addFlashBag('Success, but need to validate');
                    }
                }

                $pictures = $this->services->getRepository('picture')->findBy(['advert' => $request]);
                $questions = $this->services->getRepository('question')->findBy(['advert' => $request]);
                $this->template = 'default';
                $this->title = $request->getTitle();
                $form = new TemplateForm();
                $this->render('request/view', compact('request', 'pictures', 'questions', 'form'));
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

        if (!$user->isCompleted()) {
            $this->redirect('edit_profil', '?infos');
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

    public function addbookmark()
    {
        $user = $this->getCurrentUser();

        if(!$user){
            $this->redirect('user_login');
        }

        if ('POST' === $this->request->getMethod()) {
            $advertService = $this->services->getService('advert');
            if ($this->request->get('fav')) {
                $advert = $this->services->getRepository('advert')->find($this->request->get('fav'));
                if ($advert) {
                    $advertService->addBookmark($advert, $this->getCurrentUser());
                }
            }
        }
        die;
    }
}

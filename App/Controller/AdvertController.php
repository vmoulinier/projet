<?php


namespace App\Controller;


use Core\Controller\Controller;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class AdvertController extends Controller
{

    public function index()
    {
        $advertRepo = $this->services->getRepository('advert');
        $advertsCategories = $this->services->getRepository('advert')->findAllCategoryAdverts();
        $usersLocations = $this->services->getRepository('user')->findAllPostcodeUsers();
        $adverts = $advertRepo->findAll();

        if ('POST' === $this->request->getMethod()) {
            $limit = $this->request->get('limit');
            $start = $this->request->get('start');

            if (isset($limit, $start)) {

                if (!$this->request->get('search')) {
                    $adverts = $advertRepo->findBy([], null, $limit, $start);
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
            $advert = $this->doctrine->getRepository('App\Entity\Advert')->find($params['id']);
            $advert->setViews($advert->getViews() + 1);
            $this->services->getDoctrine()->flush();

            if ($advert) {
                if ('POST' === $this->request->getMethod()) {

                    if ($this->request->get('submitReview')) {
                        $message = $this->request->get('message');
                        $this->services->getRepository('question')->addQuestion($message, $advert, $this->getCurrentUser());
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('submitAnswer')) {
                        $message = $this->request->get('answer');
                        $questionId = $this->request->get('question_id');
                        $this->services->getRepository('answer')->addAnswer($message, $questionId);
                        $this->addFlashBag('Success, but need to validate');
                    }

                    if ($this->request->get('fav')) {
                        $this->services->getRepository('bookmark')->addBookmark($advert, $this->getCurrentUser());
                    }
                }

                $pictures = $this->services->getRepository('picture')->findBy(['advert' => $advert]);
                $questions = $this->services->getRepository('question')->findBy(['advert' => $advert]);
                $this->template = 'default';
                $this->title = $advert->getTitle();
                $this->render('advert/view', compact('advert', 'pictures', 'questions'));
            }
        }
        $this->denied();
    }
}
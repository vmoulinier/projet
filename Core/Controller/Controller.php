<?php

namespace Core\Controller;

use Core\Services\Services;
use Core\Services\Twig;
use Symfony\Component\HttpFoundation\Request;

class Controller {

    protected $path;
    protected $template;
    protected $title;
    protected $services;
    protected $twig;
    protected $flashBag = [];
    protected $request;
    protected $router;

    /**
     * Controller constructor.
     */
    public function __construct(\AltoRouter $router)
    {
        $this->path = 'App/Views/';
        $this->template = 'default';
        $this->title = PROJECT_NAME;
        $this->services = new Services($router);
        $this->twig = new Twig();
        $this->router = $router;
        $this->dataValidator();
        $this->request = new Request($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
    }

    protected function render($view, $datas = [])
    {
        ob_start();
        extract($datas);
        require($this->path . str_replace('.', '/', $view) . '.php');
        $flashBag = $this->flashBag;
        $content = ob_get_clean();
        require($this->path . 'templates/' . $this->template . '.php');
        die;
    }

    protected function denied()
    {
        $this->template = 'user';
        $this->render('error/404');
        die;
    }

    public function getCurrentUser()
    {
        if(isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            return $this->services->getEntityManager()->getRepository('App\Entity\User')->find($id);
        }
        return false;
    }

    public function redirect($path, $param = '')
    {
        try {
            header('Location: ' . $this->router->generate($path) . $param);
        } catch (\Exception $e) {
        }
    }

    public function dataValidator()
    {
        if(!empty($_POST)) {
            foreach ($_POST as $key => $data) {
                if (!is_array($data)) {
                    $_POST[$key] = htmlspecialchars($data);
                }
            }
        }
    }

    public function addFlashBag($content, $type = 'success')
    {
        $this->flashBag[0] = $content;
        $this->flashBag[1] = $type;
    }

}

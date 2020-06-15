<?php

namespace App\Controller;

use Core\Controller\Controller;

class ErrorController extends Controller
{
    public function error()
    {
        $this->template = 'user';
        $this->render('error/404');
    }
}

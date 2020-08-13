<?php

namespace App\Controller;

use Core\Controller\Controller;
use Core\HTML\TemplateForm;


class TransactionController extends Controller
{
    public function creation()
    {
        if('POST' === $this->request->getMethod()) {

            $this->template = 'transaction';
            $this->render('user/login', compact('form'));
        }
        $this->denied();
    }
}

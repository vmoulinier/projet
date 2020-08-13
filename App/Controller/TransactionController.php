<?php

namespace App\Controller;

use App\Entity\Transaction;
use Core\Controller\Controller;
use Core\HTML\TemplateForm;

class TransactionController extends Controller
{

    public function __construct(\AltoRouter $router)
    {
        parent::__construct($router);
        if(!$this->twig->logged()){
            $this->denied();
        }
    }

    public function creation()
    {
        if('POST' === $this->request->getMethod() && $this->request->get('submit')) {
            $advert = $this->services->getRepository('advert')->find($this->request->get('advert'));
            $user = $this->getCurrentUser();
            if ($advert && $advert->getUser() !== $user) {
                $form = new TemplateForm();
                $contact = $this->services->getRepository('contact')->findOneBy(['user' => $user]);
                $countries = $this->services->getRepository('country')->findAll();
                $this->template = 'transaction';
                $this->render('transaction/creation', compact('form', 'advert', 'contact', 'countries'));
            }
        }
        $this->denied();
    }

    public function validation()
    {
        if('POST' === $this->request->getMethod() && $this->request->get('submit')) {
            $advert = $this->services->getRepository('advert')->find($this->request->get('advert'));
            $user = $this->getCurrentUser();
            if ($advert && $advert->getUser() !== $this->getCurrentUser()) {
                $address = $this->request->get('address');
                $address2 = $this->request->get('address2');
                $postCode = $this->request->get('postcode');
                $phoneNumber = $this->request->get('phone');
                $city = $this->request->get('city');
                $country = $this->services->getRepository('country')->find($this->request->get('country'));
                $this->services->getService('transaction')->contactTransaction($address, $address2, $postCode, $phoneNumber, $city, $country, $user);

                $contact = $this->services->getRepository('contact')->findOneBy(['user' => $this->getCurrentUser()]);
                $transaction = $this->services->getService('transaction')->initializeTransactionAdvert($user, $advert, $contact);

                $form = new TemplateForm();
                $this->template = 'transaction';
                $this->render('transaction/validation', compact('form', 'advert', 'transaction', 'contact'));
            }
        }
        $this->denied();
    }

    public function process()
    {
        if('POST' === $this->request->getMethod() && $this->request->get('submit')) {
            $paymentMethod = $this->request->get('method');
            $transaction = $this->services->getService('transaction')->find($this->request->get('transaction'));
            if ($transaction) {
                switch ($paymentMethod) {
                    case 1:
                        $this->services->getService('payline')->processPayline();
                        break;
                    case 2:
                        $this->services->getService('paypal')->processPaypal($transaction);
                        break;
                    case 3:
                        $this->services->getService('transaction')->processTransfert();
                        break;
                }
            }
        }
        $this->denied();
    }

    public function summary()
    {

    }
}

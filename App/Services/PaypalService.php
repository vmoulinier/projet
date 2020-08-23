<?php

namespace App\Services;

use App\Entity\Transaction;
use Core\Services\Services;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;

class PaypalService extends Service
{

    private $apiContext;

    /**
     * PayalService constructor.
     */
    public function __construct(Services $services)
    {
        parent::__construct($services);
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                PAYPAL_ID,
                PAYPAL_SECRET
            )
        );
    }

    public function processPaypal(Transaction $transaction)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $list = [];
        $advertPrice = new Item();
        $advertPrice->setName($transaction->getInvoice()->getAdvert()->getTitle())
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($transaction->getAmount()/100);
        $list[] = $advertPrice;
        $price = $transaction->getAmount()/100;

        if ($transaction->getDeliveryAmount()) {
            $deliveryAmount = new Item();
            $deliveryAmount->setName('Delivery Amount')
                ->setCurrency('EUR')
                ->setQuantity(1)
                ->setPrice($transaction->getDeliveryAmount()/100);
            $list[] = $deliveryAmount;
            $price += $transaction->getDeliveryAmount()/100;
        }

        $paypalTaxes = new Item();
        $paypalTaxes->setName('Paypal Taxes')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($transaction->getPaypalTaxes()/100);
        $list[] = $paypalTaxes;
        $price += $transaction->getPaypalTaxes()/100;

        $itemList = new ItemList();
        $itemList->setItems($list);

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($price);

        $transactionPaypal = new \PayPal\Api\Transaction();
        $transactionPaypal->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(PATH . '/summary/'.$transaction->getId())
            ->setCancelUrl(PATH . '/transaction/cancel');

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transactionPaypal])
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
        } catch (\Exception $ex) {
            die($ex);
        }

        $transaction->setType(Transaction::TYPE_PAYPAL);
        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush();

        $approvalUrl = $payment->getApprovalLink();

        header('Location:'.$approvalUrl);
    }
}

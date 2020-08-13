<?php

namespace App\Services;


use App\Entity\Advert;
use App\Entity\Invoice;
use App\Entity\Transaction;

class InvoiceService extends Service
{
    public function createInvoiceAdvert(Transaction $transaction, Advert $advert): Invoice
    {
        $invoice = $transaction->getInvoice();
        if (!$invoice) {
            $invoice = new Invoice();
        }
        $invoice->setStatus(Invoice::STATUS_OUTSTANDING);
        $invoice->setCreatedAt(new \DateTime());
        $invoice->setReference(uniqid());
        $invoice->setType(Invoice::TYPE_ADVERT);
        $invoice->setAdvert($advert);

        $this->getEntityManager()->persist($invoice);
        $this->getEntityManager()->flush();

        return $invoice;
    }

    public function getNumFacture()
    {
        $date = new \DateTime();
        $year = $date->format('Y');
    }
}

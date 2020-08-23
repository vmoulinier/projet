<?php

namespace App\Services;


use App\Entity\Advert;
use App\Entity\Invoice;
use App\Entity\InvoiceLine;
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

    public function finishInvoice(Transaction $transaction): void
    {
        $invoice = $transaction->getInvoice();
        if ($invoice->getStatus() !== Invoice::STATUS_OUTSTANDING) {
            return;
        }

        $invoice->setStatus(Invoice::STATUS_CLEARED);
        $invoice->setReference($this->getNumFacture());
        $this->getEntityManager()->persist($invoice);

        $line = new InvoiceLine();
        $line->setInvoice($invoice);
        $line->setLabel($invoice->getAdvert()->getTitle());
        $line->setQuantity(1);
        $line->setUnitAmount($transaction->getAmount());
        $this->getEntityManager()->persist($line);

        if ($transaction->getDeliveryAmount()) {
            $contact = $this->getRepository('contact')->findOneBy(['user' => $transaction->getUser()]);
            $line = new InvoiceLine();
            $line->setInvoice($invoice);
            $line->setLabel($this->getTranslation('invoice.delivery.amount', ['continent' => $contact->getCountry()->getContinent()]));
            $line->setQuantity(1);
            $line->setUnitAmount($transaction->getAmount());
            $this->getEntityManager()->persist($line);
        }

        if ($transaction->getPaypalTaxes()) {
            $line = new InvoiceLine();
            $line->setInvoice($invoice);
            $line->setLabel($this->getTranslation('invoice.paypal.taxes'));
            $line->setQuantity(1);
            $line->setUnitAmount($transaction->getPaypalTaxes());
            $this->getEntityManager()->persist($line);
        }
    }

    public function getNumFacture(): int
    {
        $date = new \DateTime();
        $year = $date->format('Y');
        $lastInvoice = $this->getRepository('invoice')->findNextReference($year);

        if (!isset($lastInvoice[0])) {
            return $year . '0001';
        }

        return $lastInvoice[0]->getReference() + 1;
    }
}

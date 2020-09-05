<?php

namespace App\Services;

use App\Entity\Advert;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Entity\Rate;
use App\Entity\Transaction;
use App\Entity\User;

class TransactionService extends Service
{
    public function initializeTransactionAdvert(User $user, Advert $advert, Contact $contact): Transaction
    {
        $transaction = $this->getRepository('transaction')->findOneBy(['user' => $user, 'status' => Transaction::STATUS_PENDING]);

        if (!$transaction) {
            $transaction = new Transaction();
        }

        $transaction->setCreatedAt(new \DateTime());
        $transaction->setAmount($advert->getPrice());
        $transaction->setStatus(Transaction::STATUS_PENDING);
        $transaction->setUser($user);
        $transaction->setSeller($advert->getUser());
        $expeditionsTaxes = $this->getRepository('expeditionTaxes')->findOneBy(['advert' => $advert, 'continent' => $contact->getCountry()->getContinent()]);
        if ($expeditionsTaxes) {
            $transaction->setDeliveryAmount($expeditionsTaxes->getAmount());
        }
        $invoice = $this->services->getService('invoice')->createInvoiceAdvert($transaction, $advert);
        $transaction->setInvoice($invoice);

        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush();

        return $transaction;
    }

    public function contactTransaction(string $address, string $address2, int $postCode, int $phoneNumber, string $city, Country $country, User $user): void
    {
        $contact = $this->getRepository('contact')->findOneBy(['user' => $user]);

        if (!$contact) {
            $contact = new Contact();
        }

        $contact->setAddress($address);
        $contact->setAddress2($address2);
        $contact->setPostCode((int) $postCode);
        $contact->setPhoneNumber((int) $phoneNumber);
        $contact->setCity($city);
        $contact->setCountry($country);
        $contact->setUser($user);
        $this->getEntityManager()->persist($contact);
        $this->getEntityManager()->flush();
    }

    public function finishTransaction(Transaction $transaction): void
    {
        if ($transaction->getStatus() === Transaction::STATUS_FINISHED) {
            return;
        }
        $advert = $transaction->getInvoice()->getAdvert();
        $transaction->setStatus(Transaction::STATUS_FINISHED);
        $this->getEntityManager()->persist($transaction);
        $advert->setStatus(Advert::STATUS_PURCHASED);
        $this->getService('invoice')->finishInvoice($transaction);
        $this->getEntityManager()->flush();
        $this->services->getService('notification')->notify();
    }

    public function finishTransactionTransfert(Transaction $transaction): void
    {
        if ($transaction->getStatus() === Transaction::STATUS_FINISHED) {
            return;
        }
        $transaction->setStatus(Transaction::STATUS_FINISHED);
        $this->getEntityManager()->persist($transaction);
        $this->getService('invoice')->finishInvoice($transaction);
        $this->getEntityManager()->flush();
        $this->services->getService('notification')->notify();
    }


    public function setRating(Transaction $transaction, int $rating, string $message): void
    {
        if ($transaction->getRate()) {
            return;
        }

        $rate = new Rate();
        $rate->setRate($rating);
        $rate->setCreatedAt(new \DateTime());
        $rate->setComment($message);
        $this->getEntityManager()->persist($rate);

        $transaction->setRate($rate);
        $this->getEntityManager()->persist($transaction);

        $this->getEntityManager()->flush();
    }
}

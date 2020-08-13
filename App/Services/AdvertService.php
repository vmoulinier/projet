<?php

namespace App\Services;

use App\Entity\Advert;
use App\Entity\Answer;
use App\Entity\Bookmark;
use App\Entity\Category;
use App\Entity\ExpeditionType;
use App\Entity\Picture;
use App\Entity\Question;
use App\Entity\User;

class AdvertService extends Service
{

    public function create(string $title, Category $category, User $user, int $price, string $description, string $brand, string $shape, \DateTime $purchasedat, ExpeditionType $expeditiontype, ?string $guarantee = null): void
    {
        $advert = new Advert();
        $advert->setTitle($title) ;
        $advert->setCategory($category) ;
        $advert->setUser($user);
        $advert->setPrice($price);
        $advert->setDescription($description);
        $advert->setBrand($brand);
        $advert->setShape($shape);
        $advert->setPurchasedAt($purchasedat);
        $advert->setExpeditionType($expeditiontype);
        $advert->setGuarantee(0);
        if ($guarantee) {
            $advert->setGuarantee(1);
        }
        $advert->setType(1);
        $advert->setCreatedAt(new \DateTime());

        $this->services->getEntityManager()->persist($advert);

        if(!empty($_FILES)) {
            $pictureService = $this->services->getService('picture');
            $arrayNames = $pictureService->processPictures(DIR_ADVERT . '/' . $user->getId());
            foreach ($arrayNames as $arrayName) {
                $picture = new Picture();
                $picture->setAdvert($advert);
                $picture->setName($arrayName);
                $picture->setCreatedAt(new \DateTime());
                $this->services->getEntityManager()->persist($picture);
            }
        }

        $this->services->getEntityManager()->flush();

    }

    public function update(Advert $advert, string $title, Category $category, User $user, int $price, string $description, string $brand, string $shape, \DateTime $purchasedat, ExpeditionType $expeditiontype, ?string $guarantee = null): void
    {
        $user = $this->services->getRepository('user')->find($user->getId());
        $advert->setTitle($title) ;
        $advert->setCategory($category) ;
        $advert->setUser($user);
        $advert->setPrice($price);
        $advert->setDescription($description);
        $advert->setBrand($brand);
        $advert->setShape($shape);
        $advert->setPurchasedAt($purchasedat);
        $advert->setExpeditionType($expeditiontype);
        $advert->setGuarantee(0);
        if ($guarantee) {
            $advert->setGuarantee(1);
        }
        $advert->setType(1);
        $advert->setCreatedAt(new \DateTime());

        $this->services->getEntityManager()->persist($advert);

        if(!empty($_FILES)) {
            $pictureService = $this->services->getService('picture');
            $arrayNames = $pictureService->processPictures(DIR_ADVERT . '/' . $user->getId());
            foreach ($arrayNames as $arrayName) {
                $picture = new Picture();
                $picture->setAdvert($advert);
                $picture->setName($arrayName);
                $picture->setCreatedAt(new \DateTime());
                $this->services->getEntityManager()->persist($picture);
            }
        }

        $this->services->getEntityManager()->flush();
    }

    public function delete(Advert $advert): void
    {
        $this->services->getEntityManager()->remove($advert);
        $this->services->getEntityManager()->flush();
    }

    public function lock(Advert $advert): void
    {
        ($advert->getLocked()) ? $advert->setLocked(0) : $advert->setLocked(1);
        $this->services->getEntityManager()->persist($advert);
        $this->services->getEntityManager()->flush();
    }

    public function setView(Advert $advert): void
    {
        $advert->setViews($advert->getViews() + 1);
        $this->services->getEntityManager()->persist($advert);
        $this->services->getEntityManager()->flush();
    }

    public function addQuestion(string $message, Advert $advert, User $user): void
    {
        $question = new Question();
        $question->setMessage($message);
        $question->setCreatedAt(new \DateTime());
        $question->setAdvert($advert);
        $question->setUser($user);
        $this->services->getEntityManager()->persist($question);
        $this->services->getEntityManager()->flush();
    }

    public function addAnswer(string $message, int $questionId)
    {
        $question = $this->services->getRepository('question')->find($questionId);
        $answer = new Answer();
        $answer->setCreatedAt(new \DateTime());
        $answer->setMessage($message);
        $answer->setQuestion($question);
        $this->services->getEntityManager()->persist($answer);
        $this->services->getEntityManager()->flush();
    }

    public function addBookmark(Advert $advert, User $user): void
    {
        $bookmark = $this->services->getRepository('bookmark')->findOneBy(['advert' => $advert, 'user' => $user]);

        if ($bookmark) {
            $this->services->getEntityManager()->remove($bookmark);
        } else {
            $bookmark = new Bookmark();
            $bookmark->setUser($user);
            $bookmark->setAdvert($advert);
            $this->services->getEntityManager()->persist($bookmark);
        }

        $this->services->getEntityManager()->flush();
    }
}

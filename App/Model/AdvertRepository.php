<?php

namespace App\Model;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\ExpeditionType;
use App\Entity\Picture;
use App\Entity\User;
use Core\Services\Services;

class AdvertRepository extends Repository
{
    public function findAllCategoryAdverts()
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('a');

        return $queryBuilder->select('a')
            ->groupBy('a.category')
            ->getQuery()
            ->getResult();
    }

    public function search(?string $name, ?string $category, ?string $location, $price, $limit = null, $start = null): array
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('a');
        $res = $queryBuilder->select('a');

        if ($name) {
            $res->andWhere('a.title LIKE :name')
                ->orWhere('a.brand LIKE :name')
                ->setParameter(':name', '%'.$name.'%');
        }

        if ($category) {
            $res->andWhere('a.category = :category')
                ->setParameter(':category', $category);
        }

        if ($location) {
            $res->join('App\Entity\User', 'u')
                ->andWhere('u = a.user')
                ->andWhere('u.postCode = :location')
                ->setParameter(':location', $location);
        }

        if ($price) {
            $res->andWhere('a.price >= :price')
                ->setParameter(':price',  (int)$price*100);
        }

        if ($limit && ($start || $start === '0')) {
            $res->setFirstResult($start)
                ->setMaxResults($limit);
        }

        return $res->orderBy('a.id', 'DESC')->getQuery()->getResult();
    }

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

        $this->entityManager->getDoctrine()->persist($advert);

        if(!empty($_FILES)) {
            $services = new Services();
            $arrayNames = $services->processPictures(DIR_ADVERT . '/' . $user->getId());
            foreach ($arrayNames as $arrayName) {
                $picture = new Picture();
                $picture->setAdvert($advert);
                $picture->setName($arrayName);
                $picture->setCreatedAt(new \DateTime());
                $this->entityManager->getDoctrine()->persist($picture);
            }
        }

        $this->entityManager->getDoctrine()->flush();

    }

    public function update(Advert $advert, string $title, Category $category, User $user, int $price, string $description, string $brand, string $shape, \DateTime $purchasedat, ExpeditionType $expeditiontype, ?string $guarantee = null): void
    {
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

        $this->entityManager->getDoctrine()->persist($advert);

        if(!empty($_FILES)) {

            $services = new Services();
            $arrayNames = $services->processPictures(DIR_ADVERT . '/' . $user->getId());
            foreach ($arrayNames as $arrayName) {
                $picture = new Picture();
                $picture->setAdvert($advert);
                $picture->setName($arrayName);
                $picture->setCreatedAt(new \DateTime());
                $this->entityManager->getDoctrine()->persist($picture);
            }
        }

        $this->entityManager->getDoctrine()->flush();

    }
}

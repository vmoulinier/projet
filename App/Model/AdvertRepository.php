<?php

namespace App\Model;

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
        $res = $queryBuilder->select('a')->where('a.lock = 0');

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
}

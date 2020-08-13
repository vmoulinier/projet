<?php

namespace App\Model;

use App\Entity\User;

class UserRepository extends Repository
{

    public function search(string $name, string $email, int $id): array
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('u');

        return $queryBuilder->select('u')
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('u.name', ':name'),
                $queryBuilder->expr()->eq('u.email', ':email'),
                $queryBuilder->expr()->eq('u.id', ':id')
            ))
            ->setParameter('name', $name)
            ->setParameter('email', $email)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findAllPostcodeUsers()
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('u');

        return $queryBuilder->select('u')
            ->groupBy('u.postCode')
            ->getQuery()
            ->getResult();
    }
}

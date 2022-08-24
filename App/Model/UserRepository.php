<?php

namespace App\Model;

use Doctrine\ORM\Query\ResultSetMapping;

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

    public function findAllActiveAdvertByLocation(int $postcode)
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('res', 'res');

        $query = $this->services->getEntityManager()->createNativeQuery("SELECT COUNT(DISTINCT a.id) AS res FROM user AS u JOIN advert AS a ON a.user_id = u.id WHERE u.postCode = :postcode", $rsm);
        $query->setParameter(':postcode', $postcode);

        return $query->getResult()[0]['res'];
    }
}

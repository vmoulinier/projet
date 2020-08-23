<?php

namespace App\Model;


use App\Entity\Invoice;

class InvoiceRepository extends Repository
{

    public function findNextReference(string $year): ?array
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('i');
        $res = $queryBuilder->select('i')
            ->where('i.status = :status')
            ->andWhere('i.reference LIKE :reference')
            ->setParameter(':status', Invoice::STATUS_CLEARED)
            ->setParameter(':reference', $year . '%')
            ->setMaxResults(1);

        return $res->orderBy('i.id', 'DESC')->getQuery()->getResult();
    }
}

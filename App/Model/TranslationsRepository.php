<?php

namespace App\Model;

use App\Entity\Translations;

class TranslationsRepository extends Repository
{
    public function updateTranslation(int $id, string $name, string $fr, string $en): void
    {
        $translation = $this->find($id);
        $translation->setName(trim($name));
        $translation->setFr($fr);
        $translation->setEn($en);
        $this->entityManager->getEntityManager()->flush();
    }

    public function removeTranslation(int $id): void
    {
        $translation = $this->find($id);
        $this->entityManager->getEntityManager()->remove($translation);
        $this->entityManager->getEntityManager()->flush();
    }

    public function addTranslation(string $name, string $fr, string $en): void
    {
        $translation = $this->findBy(['name' => $name]);
        if(!$translation) {
            $translation = new Translations();
            $translation->setName(trim($name));
            $translation->setFr($fr);
            $translation->setEn($en);
            $this->entityManager->getEntityManager()->persist($translation);
            $this->entityManager->getEntityManager()->flush();
        }
    }

    public function findTranslation(string $name): array
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('t');

        return $queryBuilder->select('t')
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('t.name', ':name'),
                $queryBuilder->expr()->like('t.fr', ':name'),
                $queryBuilder->expr()->like('t.en', ':name')
            ))
            ->setMaxResults(5)
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }

}

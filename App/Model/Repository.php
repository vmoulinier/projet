<?php

namespace App\Model;

use Core\Services\Services;
use Doctrine\ORM\EntityRepository;

class Repository
{
    protected $services;

    protected $entityRepository;

    public function __construct(Services $services)
    {
        $this->services = $services;
        $this->entityRepository = $this->getEntityRepository();
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->entityRepository->find($id, $lockMode, $lockVersion);
    }

    public function findAll()
    {
        return $this->entityRepository->findAll();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->entityRepository->findOneBy($criteria, $orderBy);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function getRepository(string $entity): ?EntityRepository
    {
        if (class_exists('App\Entity\\'.ucfirst($entity))) {
            return $this->services->getEntityManager()->getRepository('App\Entity\\'.ucfirst($entity));
        }
        return null;
    }

    private function getEntityRepository(): ?EntityRepository
    {
        $currentClass = explode('\\', get_class($this));
        $currentClass = str_replace('Repository', '', $currentClass[2]);

        if (class_exists('App\Entity\\'.$currentClass)) {
            return $this->services->getEntityManager()->getRepository('App\Entity\\'.$currentClass);
        }
        return null;
    }
}

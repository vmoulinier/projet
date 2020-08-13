<?php

namespace App\Services;

use App\Model\Repository;
use Core\Services\Services;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Service
{

    protected $services;

    /**
     * Service constructor.
     */
    public function __construct(Services $services)
    {
        $this->services = $services;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->services->getEntityManager();
    }

    public function getService(string $name): Service
    {
        return $this->services->getService($name);
    }

    /**
     * @return Repository|EntityRepository
     */
    public function getRepository(string $entity)
    {
        return $this->services->getRepository($entity);
    }
}

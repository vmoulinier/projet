<?php

namespace Core\Services;

use App\Model\Repository;
use App\Services\Service;
use Core\Config\Config;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

require_once 'Core/Config/Config.php';

class Services extends Config
{

    private $router;

    /**
     * Services constructor.
     * @param \AltoRouter|null $router
     */
    public function __construct(\AltoRouter $router = null)
    {
        parent::__construct();
        $this->router = $router;
    }


    /**
     * @return Repository|EntityRepository
     */
    public function getRepository(string $entity)
    {
        if (class_exists('\App\Model\\' . ucfirst($entity) . 'Repository')) {
            $repository = '\App\Model\\' . ucfirst($entity) . 'Repository';
            return new $repository($this);
        }

        if (class_exists('\App\Entity\\' . ucfirst($entity))) {
            return $this->getEntityManager()->getRepository('\App\Entity\\' . ucfirst($entity));
        }

        throw new \Error('repository not found');
    }

    public function getService(string $name): Service
    {
        if(class_exists('\App\Services\\' . ucfirst($name) . 'Service')) {
            $service = '\App\Services\\' . ucfirst($name) . 'Service';
            return new $service($this);
        }

        throw new \Error('Service not found');
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return \AltoRouter|null
     */
    public function getRouter(): ?\AltoRouter
    {
        return $this->router;
    }
}

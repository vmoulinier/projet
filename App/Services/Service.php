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

    public function getTranslation(string $name, array $params = []): string
    {
        $lang = DEFAULT_LANGAGE;

        if (isset($_SESSION['lang'])) {
            if ($_SESSION['lang'] === 'en') {
                $lang = 'en';
            } elseif ($_SESSION['lang'] === 'fr') {
                $lang = 'fr';
            }
        }

        $translation = $this->getRepository('translations')->findOneBy(['name' => $name]);
        if ($translation) {
            $method = 'get' . ucfirst($lang);
            if (method_exists($translation, $method)) {
                $str = $translation->$method();
                foreach ($params as $key => $param) {
                    $str = str_replace('%'.$key.'%', $param, $str);
                }
                return html_entity_decode($str);
            }
        }
        $str = ' ';
        foreach ($params as $key => $param) {
            $str .= '%' . $key . '% ';
        }
        return html_entity_decode($name . $str);
    }
}

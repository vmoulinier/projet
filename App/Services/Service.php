<?php


namespace App\Services;


use Core\Services\Services;

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
}
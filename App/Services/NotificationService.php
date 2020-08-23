<?php

namespace App\Services;

use App\Entity\Picture;
use Core\Services\Services;

class NotificationService extends Service
{

    private $mj;

    /**
     * NotificationService constructor.
     */
    public function __construct(Services $services)
    {
        parent::__construct($services);
        $this->mj = $this->getService('mailjet');
    }

    public function notify()
    {

    }
}

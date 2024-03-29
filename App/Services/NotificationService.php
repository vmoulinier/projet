<?php

namespace App\Services;

use Core\Services\Services;

class NotificationService extends Service
{
    /** @var MailjetService  */
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

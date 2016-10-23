<?php

namespace RHBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use RHBundle\Entity\UserData;

class UserDataListener
{
    // Create Kernel User with automatically attributed credentials
    public function prePersist(UserData $userData, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(UserData $userData, LifecycleEventArgs $event)
    {

    }
}
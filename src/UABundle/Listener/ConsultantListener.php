<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UABundle\Entity\Consultant;

class ConsultantListener
{
    // Create number using existing numbers
    public function prePersist(Consultant $consultant, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Consultant $consultant, LifecycleEventArgs $event)
    {

    }
}
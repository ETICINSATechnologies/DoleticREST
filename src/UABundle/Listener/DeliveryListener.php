<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UABundle\Entity\Delivery;

class DeliveryListener
{
    // Create number using existing numbers
    public function prePersist(Delivery $delivery, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Delivery $delivery, LifecycleEventArgs $event)
    {

    }
}
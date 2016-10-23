<?php

namespace SupportBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SupportBundle\Entity\Ticket;

class TicketListener
{
    // Assign author using current user
    public function prePersist(Ticket $ticket, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Ticket $ticket, LifecycleEventArgs $event)
    {

    }
}
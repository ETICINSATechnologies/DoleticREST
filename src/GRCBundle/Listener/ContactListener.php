<?php

namespace GRCBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use GRCBundle\Entity\Contact;

class ContactListener
{
    // Assign author using current user
    public function prePersist(Contact $contact, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Contact $contact, LifecycleEventArgs $event)
    {

    }
}
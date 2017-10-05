<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UABundle\Entity\Consultant;
use UABundle\Entity\ProjectContact;
use UABundle\Entity\ProjectManager;

class ProjectContactListener
{
    public function postPersist(ProjectContact $contact, LifecycleEventArgs $event)
    {
        $contact->setContactFullName($contact->getContact()->getFirstName() . " " . $contact->getContact()->getLastName());
    }

    public function postUpdate(ProjectContact $contact, LifecycleEventArgs $event)
    {
        $contact->setContactFullName($contact->getContact()->getFirstName() . " " . $contact->getContact()->getLastName());
    }

    public function postLoad(ProjectContact $contact, LifecycleEventArgs $event)
    {
        $contact->setContactFullName($contact->getContact()->getFirstName() . " " . $contact->getContact()->getLastName());
    }
}
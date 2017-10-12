<?php

namespace GRCBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use GRCBundle\Entity\Contact;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContactListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Contact $contact, LifecycleEventArgs $event)
    {
        $contact
            ->setCreator(
                $contact->getCreator() == null ? $this->container->get('security.token_storage')->getToken()->getUser()
                    : $contact->getCreator())
            ->setCreationDate(new \DateTime())
            ->setLastUpdate($contact->getCreationDate());
    }

    public function preUpdate(Contact $contact, LifecycleEventArgs $event)
    {
        $contact->setLastUpdate(new \DateTime());
    }

    public function postPersist(Contact $contact, LifecycleEventArgs $event) {
        $contact->setFullName($contact->getFirstName() . ' ' . $contact->getLastName());
    }

    public function postUpdate(Contact $contact, LifecycleEventArgs $event) {
        $contact->setFullName($contact->getFirstName() . ' ' . $contact->getLastName());
    }

    public function postLoad(Contact $contact, LifecycleEventArgs $event)
    {
        $contact->setFullName($contact->getFirstName() . ' ' . $contact->getLastName());
    }
}
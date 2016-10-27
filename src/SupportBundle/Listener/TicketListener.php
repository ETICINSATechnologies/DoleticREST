<?php

namespace SupportBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SupportBundle\Entity\Ticket;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TicketListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Ticket $ticket, LifecycleEventArgs $event)
    {
        $ticket
            ->setAuthor($this->container->get('security.token_storage')->getToken()->getUser())
            ->setCreationDate(new \DateTime());
    }

    public function preUpdate(Ticket $ticket, LifecycleEventArgs $event)
    {

    }
}
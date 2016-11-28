<?php

namespace KernelBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\Position;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PositionListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(Position $position, LifecycleEventArgs $event)
    {
        // An old member cannot be president or treasurer
        if ($position->isOld()) {
            $position->setPresident(false);
            $position->setTreasurer(false);
        }

        // A member cannot be both president and treasurer
        if ($position->isPresident()) {
            $position->setTreasurer(false);
        }

        $isPresident = $position->isPresident();
        $isTreasurer = $position->isTreasurer();

        if ($isPresident || $isTreasurer) {
            $entityManager = $this->container->get('doctrine.orm.entity_manager');

            $positions = $entityManager->getRepository('KernelBundle:Position')->findAll();

            foreach ($positions as $item) {
                if ($item->getId() == $position->getId()) {
                    continue;
                }
                if ($item->isPresident() && $isPresident) {
                    $item->setPresident(false);
                } elseif ($item->isTreasurer() && $isTreasurer) {
                    $item->setTreasurer(false);
                }
            }
        }
    }

    public function postUpdate(Position $position, LifecycleEventArgs $event)
    {
        // An old member cannot be president or treasurer
        if ($position->isOld()) {
            $position->setPresident(false);
            $position->setTreasurer(false);
        }

        // A member cannot be both president and treasurer
        if ($position->isPresident()) {
            $position->setTreasurer(false);
        }

        $isPresident = $position->isPresident();
        $isTreasurer = $position->isTreasurer();

        if ($isPresident || $isTreasurer) {
            $entityManager = $this->container->get('doctrine.orm.entity_manager');

            $positions = $entityManager->getRepository('KernelBundle:Position')->findAll();

            foreach ($positions as $item) {
                if ($item->getId() == $position->getId()) {
                    continue;
                }
                if ($item->isPresident() && $isPresident) {
                    $item->setPresident(false);
                } elseif ($item->isTreasurer() && $isTreasurer) {
                    $item->setTreasurer(false);
                }
            }
        }
    }

}
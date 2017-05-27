<?php

namespace KernelBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\UserPosition;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserPositionListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(UserPosition $userPosition, LifecycleEventArgs $event)
    {
        // Set start date
        $userPosition->setStartDate(new \DateTime())->setActive(true);
    }

    public function postPersist(UserPosition $userPosition, LifecycleEventArgs $event)
    {
        $this->doPositionChecks($userPosition);
    }

    public function postUpdate(UserPosition $userPosition, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $positions = $entityManager->getRepository('KernelBundle:UserPosition')
            ->findBy(['user' => $userPosition->getUser()]);

        if ($userPosition->isMain()) {

            foreach ($positions as $position) {
                if ($position->getId() == $userPosition->getId()) {
                    continue;
                } elseif ($position->isMain()) {
                    $position->setMain(false);
                    $entityManager->persist($position);
                }
            }
            $entityManager->flush();
        }
    }

    private function doPositionChecks(UserPosition $userPosition)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $positions = $entityManager->getRepository('KernelBundle:UserPosition')
            ->findBy(['user' => $userPosition->getUser()]);

        // If the new position is an "old" one, disable others
        if ($userPosition->getPosition()->isOld()) {
            $alreadyOld = false;
            foreach ($positions as $position) {
                if ($position->getId() == $userPosition->getId()) {
                    continue;
                } elseif (!$position->getPosition()->isOld()) {
                    $position->setActive(false)->setEndDate(new \DateTime())->setMain(false);
                    $entityManager->persist($position);
                } else {
                    $alreadyOld = true;
                }
            }
            // Set as main position
            if (!$alreadyOld) {
                $userPosition->setMain(true);
                $entityManager->persist($userPosition);
            }

        } else {
            // If the new position is not old, every old position is considered inactive
            foreach ($positions as $position) {
                if ($position->getPosition()->isOld()) {
                    $position->setActive(false)->setEndDate(new \DateTime());
                    $entityManager->persist($position);
                }
            }
        }
        if ($userPosition->isMain()) {

            foreach ($positions as $position) {
                if ($position->getId() == $userPosition->getId()) {
                    continue;
                } elseif ($position->isMain()) {
                    $position->setMain(false);
                    $entityManager->persist($position);
                }
            }
        }
        $entityManager->flush();
    }

}
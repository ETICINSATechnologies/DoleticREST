<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UABundle\Entity\Consultant;
use UABundle\Entity\ProjectManager;

class ProjectManagerListener
{
    public function postPersist(ProjectManager $manager, LifecycleEventArgs $event)
    {
        $manager->setManagerFullName($manager->getManager()->getFirstName() . " " . $manager->getManager()->getLastName());
    }

    public function postUpdate(ProjectManager $manager, LifecycleEventArgs $event)
    {
        $manager->setManagerFullName($manager->getManager()->getFirstName() . " " . $manager->getManager()->getLastName());
    }

    public function postLoad(ProjectManager $manager, LifecycleEventArgs $event)
    {
        $manager->setManagerFullName($manager->getManager()->getFirstName() . " " . $manager->getManager()->getLastName());
    }
}
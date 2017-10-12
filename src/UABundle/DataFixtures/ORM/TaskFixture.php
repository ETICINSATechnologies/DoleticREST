<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\Task;

class TaskFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task = new Task();
        $task
            ->setName('Phase d\'analyse')
            ->setProject($this->getReference('project'))
            ->setJehAmount(1)
            ->setJehCost(340)
            ->setEnded(false)
            ->setStartDate(new \DateTime())
            ->setEndDate(new \DateTime());

        $manager->persist($task);
        $manager->flush();

        $this->addReference('task', $task);
    }

    public function getOrder()
    {
        return 5;
    }
}

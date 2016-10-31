<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\ProjectStatus;

class ProjectStatusFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $status = new ProjectStatus();
        $status
            ->setLabel('En sollicitation')
            ->setDetail('Non traitée');

        $manager->persist($status);
        $manager->flush();

        $this->addReference('status', $status);
    }

    public function getOrder()
    {
        return 3;
    }
}

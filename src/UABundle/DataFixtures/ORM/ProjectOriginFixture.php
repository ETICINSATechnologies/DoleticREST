<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\ProjectOrigin;

class ProjectOriginFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $origin = new ProjectOrigin();
        $origin
            ->setLabel('Mail')
            ->setDetail('Email reçu');

        $manager->persist($origin);
        $manager->flush();

        $this->addReference('origin', $origin);
    }

    public function getOrder()
    {
        return 2;
    }
}

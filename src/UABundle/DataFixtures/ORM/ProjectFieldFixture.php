<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\ProjectField;

class ProjectFieldFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $field = new ProjectField();
        $field
            ->setLabel('IF')
            ->setDetail('Informatique');

        $manager->persist($field);
        $manager->flush();

        $this->addReference('field', $field);
    }

    public function getOrder()
    {
        return 1;
    }
}

<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\SchoolYear;

class SchoolYearFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $year = new SchoolYear();
        $year->setYear(4);

        $manager->persist($year);
        $manager->flush();

        $this->addReference('year', $year);

    }

    public function getOrder()
    {
        return 1;
    }
}

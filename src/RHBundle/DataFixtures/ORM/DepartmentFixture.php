<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\Department;

class DepartmentFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $department = new Department();
        $department
            ->setLabel('IF')
            ->setDetail('Informatique')
            ->setDisabled(false);

        $manager->persist($department);
        $manager->flush();

        $this->addReference('department', $department);
    }

    public function getOrder()
    {
        return 2;
    }
}

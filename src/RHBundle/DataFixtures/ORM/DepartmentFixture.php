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
        $departmentArray = array(
            "IF" => "Informatique",
            "TC" => "Télécommunication",
            "GI" => "Génie industriel",
            "GE" => "Génie électrique",
            "BS" => "Biosciences",
            "GCU" => "Génie civil et urbanisme",
            "GEN" => "Génie environnement et nucléaire",
            "PC" => "Premier cycle",
            "GM" => "Génie Mécanique"
        );

        foreach($departmentArray as $label => $description){
            $department = new Department();
            $department
                ->setLabel($label)
                ->setDetail($description);
            $manager->persist($department);
        }

        $manager->flush();

        $this->addReference('department', $department);
    }

    public function getOrder()
    {
        return 2;
    }
}

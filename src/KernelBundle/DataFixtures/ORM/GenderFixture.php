<?php

namespace KernelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KernelBundle\Entity\Gender;

class GenderFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $genderArray = array(
            "Mr" => "Monsieur",
            "Mlle" => "Mademoiselle",
            "Mme" => "Madame"
        );

        foreach ($genderArray as $label => $detail){
            $gender = new Gender();
            $gender
                ->setLabel($label)
                ->setDetail($detail);

            $manager->persist($gender);
        }

        $manager->flush();

        $this->addReference('gender', $gender);
    }

    public function getOrder()
    {
        return 1;
    }
}

<?php

namespace KernelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KernelBundle\Entity\Country;

class CountryFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $CountryArray = array(
            "France", "Allemange", "Maroc"
        );

        foreach ($CountryArray as $label){
            $Country = new Country();
            $Country
                ->setLabel($label);

            $manager->persist($Country);
        }

        $manager->flush();

        $this->addReference('Country', $Country);
    }

    public function getOrder()
    {
        return 1;
    }
}

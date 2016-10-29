<?php

namespace GRCBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GRCBundle\Entity\FirmType;

class FirmTypeFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = new FirmType();
        $type
            ->setLabel('PME')
            ->setDetail('Petite ou Moyenne Entreprise');

        $manager->persist($type);
        $manager->flush();

        $this->addReference('firm_type', $type);
    }

    public function getOrder()
    {
        return 2;
    }
}

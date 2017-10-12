<?php

namespace GRCBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GRCBundle\Entity\Firm;

class FirmFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $firm = new Firm();
        $firm
            ->setName('Entreprise')
            ->setType($this->getReference('firm_type'));

        $manager->persist($firm);
        $manager->flush();

        $this->addReference('firm', $firm);
    }

    public function getOrder()
    {
        return 3;
    }
}

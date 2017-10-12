<?php

namespace GRCBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GRCBundle\Entity\ContactType;

class ContactTypeFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = new ContactType();
        $type
            ->setLabel('Client')
            ->setDetail('Contact ayant fourni une étude');

        $manager->persist($type);
        $manager->flush();

        $this->addReference('contact_type', $type);
    }

    public function getOrder()
    {
        return 1;
    }
}

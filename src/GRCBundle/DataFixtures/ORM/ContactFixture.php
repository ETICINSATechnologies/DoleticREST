<?php

namespace GRCBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GRCBundle\Entity\Contact;

class ContactFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $contact = new Contact();
        $contact
            ->setFirstName('Client')
            ->setLastName('Doe')
            ->setType($this->getReference('contact_type'))
            ->setOrigin("Prospection téléphonique")
            ->setFromProspecting(true)
            ->setError(false)
            ->setSatisfied(true)
            ->setCreator($this->getReference('test_user'));

        $manager->persist($contact);
        $manager->flush();

        $this->addReference('contact', $contact);
    }

    public function getOrder()
    {
        return 4;
    }
}

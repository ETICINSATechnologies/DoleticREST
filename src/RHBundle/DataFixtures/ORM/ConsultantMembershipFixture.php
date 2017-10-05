<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\ConsultantMembership;

class ConsultantMembershipFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $membership = new ConsultantMembership();
        $membership
            ->setStartDate(new \DateTime())
            ->setUser($this->getReference('test_user'))
            ->setFeePaid(true)
            ->setFormFilled(true)
            ->setIdGiven(true)
            ->setRibGiven(true)
            ->setCertificateGiven(false);

        $manager->persist($membership);
        $manager->flush();
    }

    public function getOrder()
    {
        return 6;
    }
}

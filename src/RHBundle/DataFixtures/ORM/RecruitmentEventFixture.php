<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\RecruitmentEvent;

class RecruitmentEventFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $event = new RecruitmentEvent();
        $event
            ->setDate(new \DateTime())
            ->setPresence(5);

        $manager->persist($event);
        $manager->flush();

        $this->addReference('recruitment', $event);
    }

    public function getOrder()
    {
        return 3;
    }
}

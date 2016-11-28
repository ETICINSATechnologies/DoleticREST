<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\Team;

class TeamFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $team = new Team();
        $team
            ->setLeader($this->getReference('test_user'))
            ->setName('Doletic Team')
            ->setDivision($this->getReference('division'));

        $manager->persist($team);
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}

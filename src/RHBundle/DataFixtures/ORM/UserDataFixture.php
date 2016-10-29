<?php

namespace RHBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RHBundle\Entity\UserData;

class UserDataFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userData = new UserData();
        $userData
            ->setFirstname('Nicolas')
            ->setLastname('Sorin')
            ->setEmail('nicolas.sorin@insa-lyon.fr')
            ->setRecruitmentEvent($this->getReference('recruitment'))
            ->setDepartment($this->getReference('department'))
            ->setSchoolYear($this->getReference('year'))
            ->setOld(false);

        $manager->persist($userData);
        $manager->flush();

        $this->addReference('user_data', $userData);
    }

    public function getOrder()
    {
        return 4;
    }
}

<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\Amendment;

class AmendmentFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $amendment = new Amendment();
        $amendment
            ->setProject($this->getReference('project'))
            ->setContent("Avenant sur date")
            ->setAttributable(false)
            ->setDate(new \DateTime());

        $manager->persist($amendment);
        $manager->flush();

        $this->addReference('amendment', $amendment);
    }

    public function getOrder()
    {
        return 6;
    }
}

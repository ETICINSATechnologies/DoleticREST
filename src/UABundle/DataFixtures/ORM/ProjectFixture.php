<?php

namespace UABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UABundle\Entity\Project;

class ProjectFixture extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project
            ->setName('Site web')
            ->setFirm($this->getReference('firm'))
            ->setOrigin($this->getReference('origin'))
            ->setField($this->getReference('field'))
            ->setStatus($this->getReference('status'))
            ->setManagementFee(0)
            ->setApplicationFee(0)
            ->setAdvance(0)
            ->setRebilledFee(0)
            ->setDisabled(false)
            ->setArchived(false)
            ->setCritical(false)
            ->setSecret(false);

        $manager->persist($project);
        $manager->flush();

        $this->addReference('project', $project);
    }

    public function getOrder()
    {
        return 4;
    }
}

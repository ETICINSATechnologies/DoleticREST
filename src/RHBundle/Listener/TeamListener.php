<?php

namespace RHBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\User;
use RHBundle\Entity\Team;
use RHBundle\Entity\TeamMember;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TeamListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Team $team, LifecycleEventArgs $event)
    {
        $team
            ->setCreationDate(new \DateTime());
    }

    public function postPersist(Team $team, LifecycleEventArgs $event)
    {
        $this->setLeaderAsMember($team);
    }

    public function postUpdate(Team $team, LifecycleEventArgs $event)
    {
        $this->setLeaderAsMember($team);
    }

    public function setLeaderAsMember(Team $team)
    {
        $members = $team->getMembers();
        if(!isset($members)) {
            $members = [];
        }
        foreach ($members as $member) {
            if ($member->getUserData()->getId() == $team->getLeader()->getId()) {
                return;
            }
        }

        $newMember = new TeamMember();
        $newMember->setTeam($team)->setUserData($team->getLeader());
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $entityManager->persist($newMember);
        $entityManager->flush();
    }
}
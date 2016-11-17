<?php

namespace RHBundle\Service;

use KernelBundle\Entity\User;
use RHBundle\Entity\Team;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class TeamRightsService
{

    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function userHasRights(User $user, Team $team)
    {

        if (true === $this->authorizationChecker->isGranted('ROLE_RH_SUPERADMIN')) {
            return true;
        }

        $userData = $user->getUserData();

        if (!isset($userData)) {
            return false;
        }

        if ($userData->getId() == $team->getLeader()->getId()) {
            return true;
        }

        return false;
    }

}
<?php

namespace UABundle\Service;

use KernelBundle\Entity\User;
use UABundle\Entity\Project;

class ProjectRightsService
{

    public function userHasRights(User $user, Project $project)
    {

        if (in_array('ROLE_UA_SUPERADMIN', $user->getRoles())) {
            return true;
        }

        $userData = $user->getUserData();

        if (!isset($userData)) {
            return false;
        }

        foreach ($project->getManagers() as $manager) {
            if ($userData->getId() === $manager->getManager()->getId()) {
                return true;
            }
        }

        return false;
    }

}
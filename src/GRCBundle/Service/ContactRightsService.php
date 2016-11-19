<?php

namespace GRCBundle\Service;

use KernelBundle\Entity\User;
use GRCBundle\Entity\Contact;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ContactRightsService
{

    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function userHasRights(User $user, Contact $contact)
    {

        if (true === $this->authorizationChecker->isGranted('ROLE_GRC_SUPERADMIN')) {
            return true;
        }

        $userData = $user->getUserData();

        if (!isset($userData)) {
            return false;
        }

        if ($userData->getId() == $contact->getProspector()->getId() || $user->getId() == $contact->getCreator()->getId()) {
            return true;
        }

        return false;
    }

}
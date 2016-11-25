<?php

namespace RHBundle\Service;


use Doctrine\ORM\EntityManager;
use KernelBundle\Entity\CustomMailingList;
use KernelBundle\Entity\DivisionMailingList;
use KernelBundle\Entity\MailingList;
use KernelBundle\Entity\PositionMailingList;
use KernelBundle\Entity\TeamMailingList;
use KernelBundle\Entity\User;

class DefaultMailingListService
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function makeDefaultMailingLists() {
        $users = $this->entityManager->getRepository('RHBundle:User')->findAll();

        $memberList = new CustomMailingList();
        $memberList->setDefault(true);

        $consultantList = new CustomMailingList();
        $consultantList->setDefault(true);

        foreach($users as $user) {
            // Add old member check !
            if($user->getConsultantMembership() != null) {

            }
        }
    }

}
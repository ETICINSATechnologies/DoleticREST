<?php

namespace KernelBundle\Service;


use Doctrine\ORM\EntityManager;
use KernelBundle\Entity\CustomMailingList;
use KernelBundle\Entity\DivisionMailingList;
use KernelBundle\Entity\MailingList;
use KernelBundle\Entity\PositionMailingList;
use KernelBundle\Entity\TeamMailingList;
use KernelBundle\Entity\User;

class MailingListService
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMailingListUsers(MailingList $mailingList)
    {

        if ($mailingList instanceof CustomMailingList) {

            return $mailingList->getUsers()->toArray();

        } elseif ($mailingList instanceof DivisionMailingList) {

            $queryBuilder = $this->entityManager->createQueryBuilder();
            $queryBuilder
                ->select('u')->distinct()
                ->from('u', 'KernelBundle\Entity\User')
                ->join('u.positions', 'up')
                ->addSelect('up')
                ->join('up.position', 'p')
                ->addSelect('p')
                ->join('p.division', 'd', 'Expr\Join::WITH', $queryBuilder->expr()->eq('d.id', ':id'))
                ->setParameter(':id', $mailingList->getDivision()->getId());

            return $queryBuilder->getQuery()->getArrayResult();

        } elseif ($mailingList instanceof PositionMailingList) {

            $queryBuilder = $this->entityManager->createQueryBuilder();
            $queryBuilder
                ->select('u')->distinct()
                ->from('u', 'KernelBundle\Entity\User')
                ->join('u.positions', 'up', 'Expr\Join::WITH', $queryBuilder->expr()->eq('up.position_id', ':id'))
                ->setParameter(':id', $mailingList->getPosition()->getId());

            return $queryBuilder->getQuery()->getArrayResult();

        } elseif ($mailingList instanceof TeamMailingList) {
            return [];
        }
        return ['error' => 'Type de liste inconnu !'];
    }


}
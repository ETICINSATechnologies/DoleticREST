<?php

namespace UABundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use GRCBundle\Entity\Contact;
use KernelBundle\Entity\User;
use KernelBundle\Repository\DoleticRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends DoleticRepository
{
    public function findByManager(User $user)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('p')->from($this->getClassName(), 'p', 'p.id')
            ->join('p.managers', 'm', Join::WITH, $qb->expr()->eq('m.manager', $user->getId()));
        return $qb->getQuery()->getResult();
    }

    public function findByContact(Contact $contact)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('p')->from($this->getClassName(), 'p', 'p.id')
            ->join('p.contacts', 'c', Join::WITH, $qb->expr()->eq('c.contact', $contact->getId()));
        return $qb->getQuery()->getResult();
    }

    public function findByConsultant(User $user)
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('p')->from($this->getClassName(), 'p', 'p.id')
            ->join('p.consultants', 'c', Join::WITH, $qb->expr()->eq('c.user', $user->getId()));
        return $qb->getQuery()->getResult();
    }

    public function findUnsigned()
    {
        $qb = $this->createQueryBuilder('q')
            ->select('p')
            ->from($this->getClassName(), 'p', 'p.id');
        $qb->andWhere($qb->expr()->isNull('p.signDate'))
            ->andWhere('p.disabled = ?1')
            ->andWhere('p.archived = ?2')
            ->setParameters([1 => false, 2 => false]);
        return $qb->getQuery()->getResult();
    }

    public function findCurrent()
    {
        $qb = $this->createQueryBuilder('q')
            ->select('p')
            ->from($this->getClassName(), 'p', 'p.id');
        $qb->andWhere($qb->expr()->isNotNull('p.signDate'))
            ->andWhere($qb->expr()->isNull('p.endDate'))
            ->andWhere('p.disabled = ?1')
            ->andWhere('p.archived = ?2')
            ->setParameters([1 => false, 2 => false]);
        return $qb->getQuery()->getResult();
    }
}

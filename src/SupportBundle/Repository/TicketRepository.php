<?php

namespace SupportBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('SupportBundle:Ticket', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}

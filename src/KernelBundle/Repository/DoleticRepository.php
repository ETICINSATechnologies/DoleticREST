<?php

namespace KernelBundle\Repository;


use Doctrine\ORM\EntityRepository;

class DoleticRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from($this->getClassName(), 'e', 'e.id')
            ->getQuery()->getResult();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        // Basic query with index by
        $qb = $this->createQueryBuilder('q')
            ->select('e')
            ->from($this->getClassName(), 'e', 'e.id');
        // Where
        if (isset($criteria)) {
            $i = 1;
            foreach ($criteria as $key => $value) {
                $qb->andWhere('e.' . $key . '= ?' . $i)
                    ->setParameter($i, $value);
                $i++;
            }
        }
        // Order by
        if (isset($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $qb->orderBy('e.' . $key, $value);
            }
        }
        // Limit
        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }
        if (isset($offset)) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }
}
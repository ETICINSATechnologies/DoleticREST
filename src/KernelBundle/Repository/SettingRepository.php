<?php

namespace KernelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SettingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SettingRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('KernelBundle:Setting', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}

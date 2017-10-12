<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DivisionMailingList
 *
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\DivisionMailingListRepository")
 */
class DivisionMailingList extends MailingList
{
    /**
     * @var Division
     *
     * @ORM\OneToOne(targetEntity="Division")
     */
    private $division;

    /**
     * @return Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param Division $division
     * @return DivisionMailingList
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }


}


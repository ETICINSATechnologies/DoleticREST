<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PositionMailingList
 *
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\PositionMailingListRepository")
 */
class PositionMailingList extends MailingList
{
    /**
     * @var Position
     *
     * @ORM\OneToOne(targetEntity="Position")
     */
    private $position;

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return PositionMailingList
     */
    public function setPosition($position)
    {
        $this->position = $position;
        
        return $this;
    }


}


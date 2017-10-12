<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecruitmentEvent
 *
 * @ORM\Table(name="rh_recruitment_event")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\RecruitmentEventRepository")
 */
class RecruitmentEvent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="presence", type="integer")
     */
    private $presence;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return RecruitmentEvent
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set presence
     *
     * @param integer $presence
     * @return RecruitmentEvent
     */
    public function setPresence($presence)
    {
        $this->presence = $presence;

        return $this;
    }

    /**
     * Get presence
     *
     * @return integer 
     */
    public function getPresence()
    {
        return $this->presence;
    }
}

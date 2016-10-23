<?php

namespace RHBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\Division;

/**
 * Team
 *
 * @ORM\Table(name="rh_team")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="RHBundle\Repository\TeamRepository")
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var UserData
     *
     * @ORM\ManyToOne(targetEntity="UserData")
     */
    private $leader;

    /**
     * @var Division
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Division")
     */
    private $division;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserData")
     * @ORM\JoinTable(
     *     name="rh_team_members",
     *     joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_data_id", referencedColumnName="id")}
     * )
     *
     */
    private $members;

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
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Team
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return UserData
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * @param UserData $leader
     * @return Team
     */
    public function setLeader($leader)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @param Division $division
     * @return Team
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param ArrayCollection $members
     * @return Team
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreationDateValue()
    {
        $this->creationDate = new \DateTime();
    }
}

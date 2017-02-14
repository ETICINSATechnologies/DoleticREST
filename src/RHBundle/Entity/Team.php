<?php

namespace RHBundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\Division;
use KernelBundle\Entity\User;

/**
 * Team
 *
 * @ORM\Table(name="rh_team")
 * @ORM\EntityListeners({ "RHBundle\Listener\TeamListener" })
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @SerializedName("creationDate")
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $leader;

    /**
     * @var Division
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Division")
     */
    private $division;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="TeamMember", mappedBy="team")
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
     * @return User
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * @param User $leader
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
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param array $members
     * @return Team
     */
    public function setMembers($members)
    {
        $this->members = $members;

        return $this;
    }
}

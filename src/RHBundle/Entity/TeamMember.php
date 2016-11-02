<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamMember
 *
 * @ORM\Table(name="rh_team_member")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\TeamMemberRepository")
 */
class TeamMember
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
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="members")
     *
     */
    private $team;

    /**
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="UserData")
     *
     */
    private $userData;

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
     * @return array
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param array $team
     * @return TeamMember
     */
    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return array
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @param array $userData
     * @return TeamMember
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
        return $this;
    }

}

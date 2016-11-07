<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamMember
 *
 * @ORM\Table(name="rh_team_member", uniqueConstraints={@ORM\UniqueConstraint(name="member", columns={"team_id", "user_data_id"})})
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
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="members", cascade={"remove"})
     *
     */
    private $team;

    /**
     * @var UserData
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
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     * @return TeamMember
     */
    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return UserData
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @param UserData $userData
     * @return TeamMember
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;
        return $this;
    }

}

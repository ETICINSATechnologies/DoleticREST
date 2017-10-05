<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;

/**
 * TeamMember
 *
 * @ORM\Table(name="rh_team_member", uniqueConstraints={@ORM\UniqueConstraint(name="member", columns={"team_id", "user_id"})})
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     *
     */
    private $user;

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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return TeamMember
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

}

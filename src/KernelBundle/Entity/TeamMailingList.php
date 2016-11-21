<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RHBundle\Entity\Team;

/**
 * TeamMailingList
 *
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\TeamMailingListRepository")
 */
class TeamMailingList extends MailingList
{
    /**
     * @var Team
     *
     * @ORM\OneToOne(targetEntity="RHBundle\Entity\Team")
     */
    private $team;

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     * @return TeamMailingList
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }


}


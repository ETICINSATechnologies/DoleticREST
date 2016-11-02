<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RHBundle\Entity\UserData;

/**
 * ProjectManager
 *
 * @ORM\Table(name="ua_project_manager")
 * @ORM\Entity(repositoryClass="UABundle\Repository\ProjectManagerRepository")
 */
class ProjectManager
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
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="managers", cascade={"remove"})
     *
     */
    private $project;

    /**
     * @var UserData
     *
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\UserData")
     *
     */
    private $manager;


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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return ProjectManager
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return UserData
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param UserData $manager
     * @return ProjectManager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }


}

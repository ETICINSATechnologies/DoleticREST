<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="managers")
     *
     */
    private $project;

    /**
     * @var array
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
     * @return array
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param array $project
     * @return ProjectManager
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return array
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param array $manager
     * @return ProjectManager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }


}

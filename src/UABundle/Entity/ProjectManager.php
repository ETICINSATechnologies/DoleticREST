<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;
use JMS\Serializer\Annotation\SerializedName;

/**
 * ProjectManager
 *
 * @ORM\Table(name="ua_project_manager", uniqueConstraints={@ORM\UniqueConstraint(name="manager", columns={"project_id", "manager_id"})})
 * @ORM\Entity(repositoryClass="UABundle\Repository\ProjectManagerRepository")
 * @ORM\EntityListeners({ "UABundle\Listener\ProjectManagerListener" })
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="managers")
     *
     */
    private $project;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     *
     */
    private $manager;

    /**
     * @var string
     *
     * @SerializedName("managerFullName")
     */
    private $managerFullName;


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
     * @return User
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param User $manager
     * @return ProjectManager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return string
     */
    public function getManagerFullName()
    {
        return $this->managerFullName;
    }

    /**
     * @param string $managerFullName
     * @return ProjectManager
     */
    public function setManagerFullName($managerFullName)
    {
        $this->managerFullName = $managerFullName;

        return $this;
    }

}

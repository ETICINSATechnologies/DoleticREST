<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectDocument
 *
 * @ORM\Entity(repositoryClass="UABundle\Repository\ProjectDocumentRepository")
 */
class ProjectDocument extends Document
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="documents"))
     */
    private $project;

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
     * @return ProjectDocument
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }


}

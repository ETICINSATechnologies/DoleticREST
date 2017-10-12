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
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="documents"))
     */
    private $project;

    /**
     * @var ProjectDocumentTemplate
     *
     * @ORM\ManyToOne(targetEntity="UABundle\Entity\ProjectDocumentTemplate")
     */
    private $template;

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

    /**
     * @return ProjectDocumentTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param ProjectDocumentTemplate $template
     * @return ProjectDocument
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

}

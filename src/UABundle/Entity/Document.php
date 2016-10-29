<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\User;

/**
 * Document
 *
 * @ORM\Table(name="ua_document")
 * @ORM\Entity(repositoryClass="UABundle\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="documents")
     */
    private $project;

    /**
     * @var DocumentTemplate
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\DocumentTemplate")
     */
    private $template;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $auditor;

    /**
     * @var bool
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;


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
     * Set valid
     *
     * @param boolean $valid
     * @return Document
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
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
     * @return Document
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return DocumentTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param DocumentTemplate $template
     * @return Document
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuditor()
    {
        return $this->auditor;
    }

    /**
     * @param User $auditor
     * @return Document
     */
    public function setAuditor($auditor)
    {
        $this->auditor = $auditor;

        return $this;
    }

}

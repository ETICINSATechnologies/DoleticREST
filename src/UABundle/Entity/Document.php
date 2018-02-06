<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\Upload;
use KernelBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="ua_document")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Entity(repositoryClass="UABundle\Repository\DocumentRepository")
 */
abstract class Document
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
     * @ORM\ManyToOne(targetEntity="Project")
     *
     */
    private $project;

    /**
     * @var DocumentTemplate
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\DocumentTemplate")
     */
    private $template;

    /**
     * @var Upload
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Upload")
     */
    private $upload;

    /**
     * @var bool
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $auditor;

    /**
     * @return int
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
     * @return Upload
     */
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * @param Upload $upload
     * @return Document
     */
    public function setUpload($upload)
    {
        $this->upload = $upload;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     * @return Document
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
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

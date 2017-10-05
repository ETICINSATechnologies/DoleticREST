<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="ua_document")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"project" = "ProjectDocument", "consultant" = "ConsultantDocument", "delivery" = "DeliveryDocument" })
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
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Merci d'uploader un fichier au format PDF")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $file;

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

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     * @return Document
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

}

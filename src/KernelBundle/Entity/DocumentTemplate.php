<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * DocumentTemplate
 *
 * @ORM\Table(name="kernel_document_template", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_label_version", columns={"label", "version"})
 * })
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\DocumentTemplateRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "project" = "UABundle\Entity\ProjectDocumentTemplate",
 *     "consultant" = "UABundle\Entity\ConsultantDocumentTemplate",
 *     "delivery" = "UABundle\Entity\DeliveryDocumentTemplate",
 *     "standard" = "UABundle\Entity\StandardDocumentTemplate"
 * })
 */
abstract class DocumentTemplate
{


    public function __construct()
    {
        $this->lastUpload = new \DateTime();
        $this->deprecated=false;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="visibility", type="string")
     */
    private $visibility;

    /**
     * @var bool
     *
     * @ORM\Column(name="deprecated", type="boolean")
     */
    private $deprecated;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     *
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_upload", type="datetime")
     */
    private $lastUpload;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return DocumentTemplate
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DocumentTemplate
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set visibility
     *
     * @param array $visibility
     *
     * @return string
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set deprecated
     *
     * @param boolean $deprecated
     *
     * @return DocumentTemplate
     */
    public function setDeprecated($deprecated)
    {
        $this->deprecated = $deprecated;

        return $this;
    }

    /**
     * Get deprecated
     *
     * @return bool
     */
    public function getDeprecated()
    {
        return $this->deprecated;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return string
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return string
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     **/
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set lastUpload
     *
     * @param \DateTime $lastUpload
     *
     * @return string
     */
    public function setLastUpload($lastUpload)
    {
        $this->lastUpload = $lastUpload;

        return $this;
    }

    /**
     * Get lastUpload
     *
     * @return \DateTime
     */
    public function getLastUpload()
    {
        return $this->lastUpload;
    }
}





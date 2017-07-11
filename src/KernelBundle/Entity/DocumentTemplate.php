<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentTemplate
 *
 * @ORM\Table(name="kernel_document_template")
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\DocumentTemplateRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "project" = "UABundle\Entity\ProjectDocumentTemplate",
 *     "consultant" = "UABundle\Entity\ConsultantDocumentTemplate",
 *     "delivery" = "UABundle\Entity\DeliveryDocumentTemplate"
 * })
 */
abstract class DocumentTemplate
{


    public function __construct()
    {
        $this->lastUpload = new \Datetime();
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
     * @var array
     *
     * @ORM\Column(name="visibility", type="array")
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
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_upload", type="date")
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
     * @return DocumentTemplate
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility
     *
     * @return array
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
    public function setName($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getName()
    {
        return $this->label;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return DocumentTemplate
     */
    public function setDownloadLink($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getDownloadLink()
    {
        return $this->path;
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

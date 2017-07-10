<?php

namespace DTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="standard_document")
 * @ORM\Entity(repositoryClass="DTBundle\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="download_link", type="string", length=255, unique=true)
     */
    private $downloadLink;

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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * @return Document
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
     * Set name
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set downloadLink
     *
     * @param string $downloadLink
     *
     * @return Document
     */
    public function setDownloadLink($downloadLink)
    {
        $this->downloadLink = $downloadLink;

        return $this;
    }

    /**
     * Get downloadLink
     *
     * @return string
     */
    public function getDownloadLink()
    {
        return $this->downloadLink;
    }

    /**
     * Set lastUpload
     *
     * @param \DateTime $lastUpload
     *
     * @return Document
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

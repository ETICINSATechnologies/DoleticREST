<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Upload
 *
 * @ORM\Table(name="kernel_upload")
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\UploadRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Upload
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
    private $uploader;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="date")
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $storageFilename;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * @param User $uploader
     * @return Upload
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     * @return Upload
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     * @return Upload
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStorageFilename()
    {
        return $this->storageFilename;
    }

    /**
     * @param mixed $storageFilename
     * @return Upload
     */
    public function setStorageFilename($storageFilename)
    {
        $this->storageFilename = $storageFilename;
        return $this;
    }

}

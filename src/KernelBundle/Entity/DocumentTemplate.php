<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentTemplate
 *
 * @ORM\Table(name="kernel_document_template")
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\DocumentTemplateRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class DocumentTemplate
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
     * @var Upload
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Upload")
     */
    private $upload;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return DocumentTemplate
     */
    public function setUpload($upload)
    {
        $this->upload = $upload;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DocumentTemplate
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return DocumentTemplate
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }



}

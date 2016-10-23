<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="rh_department")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\DepartmentRepository")
 */
class Department
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255, nullable=true)
     */
    private $details;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled;


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
     * Set label
     *
     * @param string $label
     * @return Department
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
     * Set details
     *
     * @param string $details
     * @return Department
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     * @return Department
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

}

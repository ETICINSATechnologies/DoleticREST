<?php

namespace UABundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;

/**
 * Consultant
 *
 * @ORM\Table(name="ua_consultant", uniqueConstraints={@ORM\UniqueConstraint(name="member", columns={"project_id", "user_id"})})
 * @ORM\Entity(repositoryClass="UABundle\Repository\ConsultantRepository")
 * @ORM\EntityListeners({ "UABundle\Listener\ConsultantListener" })
 */
class Consultant
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="consultants"))
     */
    private $project;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var int
     *
     * @SerializedName("jehAssigned")
     * @ORM\Column(name="jeh_assigned", type="integer")
     */
    private $jehAssigned;

    /**
     * @var int
     *
     * @SerializedName("payByJeh")
     * @ORM\Column(name="pay_by_jeh", type="integer")
     */
    private $payByJeh;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ConsultantDocument", mappedBy="consultant"))
     */
    private $documents;

    /**
     * @var string
     *
     * @SerializedName("consultantFullName")
     */
    private $consultantFullName;


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
     * Set number
     *
     * @param integer $number
     * @return Consultant
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set jehAssigned
     *
     * @param integer $jehAssigned
     * @return Consultant
     */
    public function setJehAssigned($jehAssigned)
    {
        $this->jehAssigned = $jehAssigned;

        return $this;
    }

    /**
     * Get jehAssigned
     *
     * @return integer
     */
    public function getJehAssigned()
    {
        return $this->jehAssigned;
    }

    /**
     * Set payByJeh
     *
     * @param integer $payByJeh
     * @return Consultant
     */
    public function setPayByJeh($payByJeh)
    {
        $this->payByJeh = $payByJeh;

        return $this;
    }

    /**
     * Get payByJeh
     *
     * @return integer
     */
    public function getPayByJeh()
    {
        return $this->payByJeh;
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
     * @return Consultant
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Consultant
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param ArrayCollection $documents
     * @return Consultant
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConsultantFullName()
    {
        return $this->consultantFullName;
    }

    /**
     * @param mixed $consultantFullName
     * @return Consultant
     */
    public function setConsultantFullName($consultantFullName)
    {
        $this->consultantFullName = $consultantFullName;

        return $this;
    }

}

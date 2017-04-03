<?php

namespace RHBundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;

/**
 * ConsultantMembership
 *
 * @ORM\Table(name="rh_consultant_membership")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\ConsultantMembershipRepository")
 */
class ConsultantMembership
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
     * @ORM\OneToOne(targetEntity="KernelBundle\Entity\User", inversedBy="consultantMembership"))
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @SerializedName("startDate")
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var string
     *
     * @SerializedName("socialNumber")
     * @ORM\Column(name="social_number", type="string", length=15, nullable=true)
     */
    private $socialNumber;

    /**
     * @var bool
     *
     * @SerializedName("feePaid")
     * @ORM\Column(name="fee_paid", type="boolean")
     */
    private $feePaid;

    /**
     * @var bool
     *
     * @SerializedName("formFilled")
     * @ORM\Column(name="form_filled", type="boolean")
     */
    private $formFilled;

    /**
     * @var bool
     *
     * @SerializedName("ribGiven")
     * @ORM\Column(name="rib_given", type="boolean")
     */
    private $ribGiven;

    /**
     * @var bool
     *
     * @SerializedName("idGiven")
     * @ORM\Column(name="id_given", type="boolean")
     */
    private $idGiven;

    /**
     * @var bool
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return ConsultantMembership
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set socialNumber
     *
     * @param string $socialNumber
     * @return ConsultantMembership
     */
    public function setSocialNumber($socialNumber)
    {
        $this->socialNumber = $socialNumber;

        return $this;
    }

    /**
     * Get socialNumber
     *
     * @return string
     */
    public function getSocialNumber()
    {
        return $this->socialNumber;
    }

    /**
     * Set feePaid
     *
     * @param boolean $feePaid
     * @return ConsultantMembership
     */
    public function setFeePaid($feePaid)
    {
        $this->feePaid = $feePaid;

        return $this;
    }

    /**
     * Get feePaid
     *
     * @return boolean
     */
    public function getFeePaid()
    {
        return $this->feePaid;
    }

    /**
     * Set formFilled
     *
     * @param boolean $formFilled
     * @return ConsultantMembership
     */
    public function setFormFilled($formFilled)
    {
        $this->formFilled = $formFilled;

        return $this;
    }

    /**
     * Get formFilled
     *
     * @return boolean
     */
    public function getFormFilled()
    {
        return $this->formFilled;
    }

    /**
     * Set ribGiven
     *
     * @param boolean $ribGiven
     * @return ConsultantMembership
     */
    public function setRibGiven($ribGiven)
    {
        $this->ribGiven = $ribGiven;

        return $this;
    }

    /**
     * Get ribGiven
     *
     * @return boolean
     */
    public function getRibGiven()
    {
        return $this->ribGiven;
    }

    /**
     * Set idGiven
     *
     * @param boolean $idGiven
     * @return ConsultantMembership
     */
    public function setIdGiven($idGiven)
    {
        $this->idGiven = $idGiven;

        return $this;
    }

    /**
     * Get idGiven
     *
     * @return boolean
     */
    public function getIdGiven()
    {
        return $this->idGiven;
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
     * @return ConsultantMembership
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param mixed $valid
     * @return ConsultantMembership
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

}

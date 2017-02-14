<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;

/**
 * AdministratorMembership
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="rh_administrator_membership")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\AdministratorMembershipRepository")
 */
class AdministratorMembership
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
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User", inversedBy="administrator_memberships"))
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
     * @var \DateTime
     *
     * @SerializedName("endDate")
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

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
     * @return AdministratorMembership
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
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return AdministratorMembership
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set feePaid
     *
     * @param boolean $feePaid
     * @return AdministratorMembership
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
     * @return AdministratorMembership
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return AdministratorMembership
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setDefaultEndDate()
    {
        if(!isset($this->endDate)) {
            $this->endDate = $this->startDate;
            $this->endDate->modify('+1 year');
        }
    }
}

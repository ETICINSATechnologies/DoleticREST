<?php

namespace RHBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdministratorMembership
 *
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
     * @var UserData
     *
     * @ORM\ManyToOne(targetEntity="UserData", inversedBy="administrator_memberships"))
     */
    private $user_data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="fee_paid", type="boolean")
     */
    private $feePaid;

    /**
     * @var bool
     *
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
     * @return UserData
     */
    public function getUserData()
    {
        return $this->user_data;
    }

    /**
     * @param UserData $user_data
     * @return AdministratorMembership
     */
    public function setUserData($user_data)
    {
        $this->user_data = $user_data;

        return $this;
    }

}

<?php

namespace RHBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\Country;
use KernelBundle\Entity\Gender;
use KernelBundle\Entity\User;

/**
 * UserData
 *
 * @ORM\Table(name="rh_user_data")
 * @ORM\Entity(repositoryClass="RHBundle\Repository\UserDataRepository")
 */
class UserData
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
     * @ORM\OneToOne(targetEntity="KernelBundle\Entity\User", mappedBy="user_data")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="postal_code", type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @var bool
     *
     * @ORM\Column(name="old", type="boolean")
     */
    private $old;

    /**
     * @var SchoolYear
     *
     * @ORM\ManyToOne(targetEntity="SchoolYear")
     */
    private $school_year;

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="Department")
     */
    private $department;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Gender")
     */
    private $gender;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Country")
     */
    private $country;

    /**
     * @var RecruitmentEvent
     *
     * @ORM\ManyToOne(targetEntity="RecruitmentEvent")
     */
    private $recruitment_event;

    /**
     * @var ConsultantMembership
     *
     * @ORM\OneToOne(targetEntity="ConsultantMembership", mappedBy="user_data"))
     */
    private $consultant_membership;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AdministratorMembership", mappedBy="user_data"))
     */
    private $administrator_memberships;

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
     * Set firstname
     *
     * @param string $firstname
     * @return UserData
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return UserData
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return UserData
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     * @return UserData
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return integer
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return UserData
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return UserData
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return UserData
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set old
     *
     * @param boolean $old
     * @return UserData
     */
    public function setOld($old)
    {
        $this->old = $old;

        return $this;
    }

    /**
     * Get old
     *
     * @return boolean
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return UserData
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return SchoolYear
     */
    public function getSchoolYear()
    {
        return $this->school_year;
    }

    /**
     * @param SchoolYear $school_year
     * @return UserData
     */
    public function setSchoolYear($school_year)
    {
        $this->school_year = $school_year;

        return $this;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     * @return UserData
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     * @return UserData
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return UserData
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return RecruitmentEvent
     */
    public function getRecruitmentEvent()
    {
        return $this->recruitment_event;
    }

    /**
     * @param RecruitmentEvent $recruitment_event
     * @return UserData
     */
    public function setRecruitmentEvent($recruitment_event)
    {
        $this->recruitment_event = $recruitment_event;

        return $this;
    }

    /**
     * @return ConsultantMembership
     */
    public function getConsultantMembership()
    {
        return $this->consultant_membership;
    }

    /**
     * @param ConsultantMembership $consultant_membership
     * @return UserData
     */
    public function setConsultantMembership($consultant_membership)
    {
        $this->consultant_membership = $consultant_membership;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAdministratorMemberships()
    {
        return $this->administrator_memberships;
    }

    /**
     * @param ArrayCollection $administrator_memberships
     * @return UserData
     */
    public function setAdministratorMemberships($administrator_memberships)
    {

        $this->administrator_memberships = $administrator_memberships;
        return $this;
    }

}

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
 * @ORM\EntityListeners({ "RHBundle\Listener\UserDataListener" })
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
    private $schoolYear;

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
    private $recruitmentEvent;

    /**
     * @var ConsultantMembership
     *
     * @ORM\OneToOne(targetEntity="ConsultantMembership", mappedBy="userData"))
     */
    private $consultantMembership;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AdministratorMembership", mappedBy="userData"))
     */
    private $administratorMemberships;

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
     * Get full name
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
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
        return $this->schoolYear;
    }

    /**
     * @param SchoolYear $schoolYear
     * @return UserData
     */
    public function setSchoolYear($schoolYear)
    {
        $this->schoolYear = $schoolYear;

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
        return $this->recruitmentEvent;
    }

    /**
     * @param RecruitmentEvent $recruitmentEvent
     * @return UserData
     */
    public function setRecruitmentEvent($recruitmentEvent)
    {
        $this->recruitmentEvent = $recruitmentEvent;

        return $this;
    }

    /**
     * @return ConsultantMembership
     */
    public function getConsultantMembership()
    {
        return $this->consultantMembership;
    }

    /**
     * @param ConsultantMembership $consultantMembership
     * @return UserData
     */
    public function setConsultantMembership($consultantMembership)
    {
        $this->consultantMembership = $consultantMembership;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAdministratorMemberships()
    {
        return $this->administratorMemberships;
    }

    /**
     * @param ArrayCollection $administratorMemberships
     * @return UserData
     */
    public function setAdministratorMemberships($administratorMemberships)
    {

        $this->administratorMemberships = $administratorMemberships;
        return $this;
    }

}

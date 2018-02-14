<?php

namespace KernelBundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use RHBundle\Entity\ConsultantMembership;
use RHBundle\Entity\Department;
use RHBundle\Entity\RecruitmentEvent;
use RHBundle\Entity\SchoolYear;
use RHBundle\RHBundle;

/**
 * User
 *
 * @ORM\Table(name="kernel_user")
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\UserRepository")
 * @ORM\EntityListeners({ "KernelBundle\Listener\UserListener" })
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="UserPosition", mappedBy="user", cascade={"persist", "remove"})
     */
    private $positions;

    /**
     * @var string
     *
     * @SerializedName("firstName")
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @SerializedName("lastName")
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @SerializedName("birthDate")
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
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
     * @SerializedName("postalCode")
     * @ORM\Column(name="postal_code", type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @var SchoolYear
     *
     * @SerializedName("schoolYear")
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\SchoolYear")
     */
    private $schoolYear;

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\Department")
     */
    private $department;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="Gender")
     */
    private $gender;

    /**
     * @var Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     */
    private $country;

    /**
     * @var RecruitmentEvent
     *
     * @SerializedName("recruitmentEvent")
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\RecruitmentEvent")
     */
    private $recruitmentEvent;

    /**
     * @var ConsultantMembership
     *
     * @SerializedName("consultantMembership")
     * @ORM\OneToOne(targetEntity="RHBundle\Entity\ConsultantMembership", mappedBy="user", fetch="EXTRA_LAZY")
     */
    private $consultantMembership;

    /**
     * @var ArrayCollection
     *
     * @SerializedName("administratorMemberships")
     * @ORM\OneToMany(targetEntity="RHBundle\Entity\AdministratorMembership", mappedBy="user", fetch="EXTRA_LAZY")
     */
    private $administratorMemberships;

    /**
     * @var string
     *
     * @SerializedName("fullName")
     */
    private $fullName;

    /**
     * @var Position
     *
     * @SerializedName("mainPosition")
     */
    private $mainPosition;

    /**
     * @var int
     */
    private $administrator;

    /**
     * @var int
     */
    private $consultant;

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
     * @return array
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param array $positions
     * @return User
     */
    public function setPositions($positions)
    {
        $this->positions = $positions;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        foreach ($this->positions as $position) {
            if ($position->getActive()) {
                $roles = array_merge($roles, $position->getPosition()->getRoles());
            }
        }
        return $roles;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
     */
    public function setAdministratorMemberships($administratorMemberships)
    {
        $this->administratorMemberships = $administratorMemberships;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMainPosition()
    {
        return $this->mainPosition;
    }

    /**
     * @param mixed $mainPosition
     * @return User
     */
    public function setMainPosition($mainPosition)
    {
        $this->mainPosition = $mainPosition;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdministrator()
    {
        return $this->administrator;
    }

    /**
     * @param int $administrator
     * @return User
     */
    public function setAdministrator($administrator)
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * @return int
     */
    public function getConsultant()
    {
        return $this->consultant;
    }

    /**
     * @param int $consultant
     * @return User
     */
    public function setConsultant($consultant)
    {
        $this->consultant = $consultant;
        
        return $this;
    }

}

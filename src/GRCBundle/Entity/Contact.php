<?php

namespace GRCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\Gender;
use KernelBundle\Entity\User;

/**
 * Contact
 *
 * @ORM\Table(name="grc_contact")
 * @ORM\Entity(repositoryClass="GRCBundle\Repository\ContactRepository")
 * @ORM\EntityListeners({ "GRCBundle\Listener\ContactListener" })
 */
class Contact
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", nullable=true)
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="cell_phone", type="integer", nullable=true)
     */
    private $cellPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="from_prospecting", type="boolean")
     */
    private $fromProspecting;

    /**
     * @var boolean
     *
     * @ORM\Column(name="error", type="boolean")
     */
    private $error;

    /**
     * @var boolean
     *
     * @ORM\Column(name="satisfied", type="boolean")
     */
    private $satisfied;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_prospecting", type="datetime", nullable=true)
     */
    private $nextProspecting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var ContactType
     *
     * @ORM\ManyToOne(targetEntity="ContactType")
     */
    private $type;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\Gender")
     */
    private $gender;

    /**
     * @var Firm
     *
     * @ORM\ManyToOne(targetEntity="Firm")
     */
    private $firm;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $prospector;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $creator;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ContactAction", mappedBy="contact", fetch="EXTRA_LAZY")
     */
    private $actions;

    /**
     * @var string
     */
    private $fullName;


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
     * Set firstName
     *
     * @param string $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Contact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set cellPhone
     *
     * @param integer $cellPhone
     * @return Contact
     */
    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    /**
     * Get cellPhone
     *
     * @return integer
     */
    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Contact
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Contact
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return mixed
     */
    public function getNextProspecting()
    {
        return $this->nextProspecting;
    }

    /**
     * @param mixed $nextProspecting
     * @return Contact
     */
    public function setNextProspecting($nextProspecting)
    {
        $this->nextProspecting = $nextProspecting;

        return $this;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Contact
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Contact
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @return ContactType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ContactType $type
     * @return Contact
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return Contact
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Firm
     */
    public function getFirm()
    {
        return $this->firm;
    }

    /**
     * @param Firm $firm
     * @return Contact
     */
    public function setFirm($firm)
    {
        $this->firm = $firm;

        return $this;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     * @return Contact
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     * @return Contact
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isError()
    {
        return $this->error;
    }

    /**
     * @param boolean $error
     * @return Contact
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSatisfied()
    {
        return $this->satisfied;
    }

    /**
     * @param boolean $satisfied
     * @return Contact
     */
    public function setSatisfied($satisfied)
    {
        $this->satisfied = $satisfied;

        return $this;
    }

    /**
     * @return User
     */
    public function getProspector()
    {
        return $this->prospector;
    }

    /**
     * @param User $prospector
     * @return Contact
     */
    public function setProspector($prospector)
    {
        $this->prospector = $prospector;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isFromProspecting()
    {
        return $this->fromProspecting;
    }

    /**
     * @param boolean $fromProspecting
     * @return Contact
     */
    public function setFromProspecting($fromProspecting)
    {
        $this->fromProspecting = $fromProspecting;

        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param array $actions
     * @return Contact
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

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
     * @return Contact
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

}

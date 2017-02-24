<?php

namespace UABundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GRCBundle\Entity\Firm;
use KernelBundle\Entity\User;

/**
 * Project
 *
 * @ORM\Table(name="ua_project")
 * @ORM\Entity(repositoryClass="UABundle\Repository\ProjectRepository")
 * @ORM\EntityListeners({ "UABundle\Listener\ProjectListener" })
 */
class Project
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer", unique=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @SerializedName("signDate")
     * @ORM\Column(name="sign_date", type="date", nullable=true)
     */
    private $signDate;

    /**
     * @var \DateTime
     *
     * @SerializedName("endDate")
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var int
     *
     * @SerializedName("managementFee")
     * @ORM\Column(name="management_fee", type="integer")
     */
    private $managementFee;

    /**
     * @var int
     *
     * @SerializedName("applicationFee")
     * @ORM\Column(name="application_fee", type="integer")
     */
    private $applicationFee;

    /**
     * @var int
     *
     * @SerializedName("rebilledFee")
     * @ORM\Column(name="rebilled_fee", type="integer")
     */
    private $rebilledFee;

    /**
     * @var int
     *
     * @ORM\Column(name="advance", type="integer")
     */
    private $advance;

    /**
     * @var int
     *
     * @SerializedName("expectedDuration")
     * @ORM\Column(name="expected_duration", type="integer", nullable=true)
     */
    private $expectedDuration;

    /**
     * @var bool
     *
     * @ORM\Column(name="secret", type="boolean")
     */
    private $secret;

    /**
     * @var bool
     *
     * @ORM\Column(name="critical", type="boolean")
     */
    private $critical;

    /**
     * @var \DateTime
     *
     * @SerializedName("creationDate")
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @SerializedName("lastUpdate")
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="disabled", type="boolean")
     */
    private $disabled;

    /**
     * @var \DateTime
     *
     * @SerializedName("disabledSince")
     * @ORM\Column(name="disabled_since", type="datetime", nullable=true)
     */
    private $disabledSince;

    /**
     * @var \DateTime
     *
     * @SerializedName("disabledUntil")
     * @ORM\Column(name="disabled_until", type="datetime", nullable=true)
     */
    private $disabledUntil;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived;

    /**
     * @var \DateTime
     *
     * @SerializedName("archivedSince")
     * @ORM\Column(name="archived_since", type="datetime", nullable=true)
     */
    private $archivedSince;

    /**
     * @var Firm
     *
     * @ORM\ManyToOne(targetEntity="GRCBundle\Entity\Firm")
     */
    private $firm;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $auditor;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ProjectManager", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     *
     */
    private $managers;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ProjectContact", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     *
     */
    private $contacts;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Consultant", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $consultants;

    /**
     * @var ProjectField
     *
     * @ORM\ManyToOne(targetEntity="ProjectField")
     */
    private $field;

    /**
     * @var ProjectOrigin
     *
     * @ORM\ManyToOne(targetEntity="ProjectOrigin")
     */
    private $origin;

    /**
     * @var ProjectStatus
     *
     * @ORM\ManyToOne(targetEntity="ProjectStatus")
     */
    private $status;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $tasks;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Amendment", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $amendments;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ProjectDocument", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $documents;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="ProjectFile", mappedBy="project", fetch="EXTRA_LAZY", cascade={"remove"})
     */
    private $files;

    /**
     * @var boolean
     *
     * @SerializedName("userHasRights")
     */
    private $userHasRights;

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
     * @return Project
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
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set signDate
     *
     * @param \DateTime $signDate
     * @return Project
     */
    public function setSignDate($signDate)
    {
        $this->signDate = $signDate;

        return $this;
    }

    /**
     * Get signDate
     *
     * @return \DateTime
     */
    public function getSignDate()
    {
        return $this->signDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Project
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
     * Set managementFee
     *
     * @param integer $managementFee
     * @return Project
     */
    public function setManagementFee($managementFee)
    {
        $this->managementFee = $managementFee;

        return $this;
    }

    /**
     * Get managementFee
     *
     * @return integer
     */
    public function getManagementFee()
    {
        return $this->managementFee;
    }

    /**
     * Set applicationFee
     *
     * @param integer $applicationFee
     * @return Project
     */
    public function setApplicationFee($applicationFee)
    {
        $this->applicationFee = $applicationFee;

        return $this;
    }

    /**
     * Get applicationFee
     *
     * @return integer
     */
    public function getApplicationFee()
    {
        return $this->applicationFee;
    }

    /**
     * Set rebilledFee
     *
     * @param integer $rebilledFee
     * @return Project
     */
    public function setRebilledFee($rebilledFee)
    {
        $this->rebilledFee = $rebilledFee;

        return $this;
    }

    /**
     * Get rebilledFee
     *
     * @return integer
     */
    public function getRebilledFee()
    {
        return $this->rebilledFee;
    }

    /**
     * Set advance
     *
     * @param integer $advance
     * @return Project
     */
    public function setAdvance($advance)
    {
        $this->advance = $advance;

        return $this;
    }

    /**
     * Get advance
     *
     * @return integer
     */
    public function getAdvance()
    {
        return $this->advance;
    }

    /**
     * @return int
     */
    public function getExpectedDuration()
    {
        return $this->expectedDuration;
    }

    /**
     * @param int $expectedDuration
     * @return Project
     */
    public function setExpectedDuration($expectedDuration)
    {
        $this->expectedDuration = $expectedDuration;

        return $this;
    }

    /**
     * Set secret
     *
     * @param boolean $secret
     * @return Project
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * Get secret
     *
     * @return boolean
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Set critical
     *
     * @param boolean $critical
     * @return Project
     */
    public function setCritical($critical)
    {
        $this->critical = $critical;

        return $this;
    }

    /**
     * Get critical
     *
     * @return boolean
     */
    public function getCritical()
    {
        return $this->critical;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Project
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
     * @return Project
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
     * Set disabled
     *
     * @param boolean $disabled
     * @return Project
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set disabledSince
     *
     * @param \DateTime $disabledSince
     * @return Project
     */
    public function setDisabledSince($disabledSince)
    {
        $this->disabledSince = $disabledSince;

        return $this;
    }

    /**
     * Get disabledSince
     *
     * @return \DateTime
     */
    public function getDisabledSince()
    {
        return $this->disabledSince;
    }

    /**
     * Set disabledUntil
     *
     * @param \DateTime $disabledUntil
     * @return Project
     */
    public function setDisabledUntil($disabledUntil)
    {
        $this->disabledUntil = $disabledUntil;

        return $this;
    }

    /**
     * Get disabledUntil
     *
     * @return \DateTime
     */
    public function getDisabledUntil()
    {
        return $this->disabledUntil;
    }

    /**
     * Set archived
     *
     * @param boolean $archived
     * @return Project
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Set archivedSince
     *
     * @param \DateTime $archivedSince
     * @return Project
     */
    public function setArchivedSince($archivedSince)
    {
        $this->archivedSince = $archivedSince;

        return $this;
    }

    /**
     * Get archivedSince
     *
     * @return \DateTime
     */
    public function getArchivedSince()
    {
        return $this->archivedSince;
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
     * @return Project
     */
    public function setFirm($firm)
    {
        $this->firm = $firm;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuditor()
    {
        return $this->auditor;
    }

    /**
     * @param User $auditor
     * @return Project
     */
    public function setAuditor($auditor)
    {
        $this->auditor = $auditor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @param mixed $managers
     * @return Project
     */
    public function setManagers($managers)
    {
        $this->managers = $managers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     * @return Project
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @return ProjectField
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param ProjectField $field
     * @return Project
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return ProjectOrigin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param ProjectOrigin $origin
     * @return Project
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return ProjectStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param ProjectStatus $status
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getConsultants()
    {
        return $this->consultants;
    }

    /**
     * @param ArrayCollection $consultants
     * @return Project
     */
    public function setConsultants($consultants)
    {
        $this->consultants = $consultants;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param ArrayCollection $tasks
     * @return Project
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAmendments()
    {
        return $this->amendments;
    }

    /**
     * @param ArrayCollection $amendments
     * @return Project
     */
    public function setAmendments($amendments)
    {
        $this->amendments = $amendments;

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
     * @return Project
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreationDateValue()
    {
        $this->creationDate = new \DateTime();
        $this->lastUpdate = $this->creationDate;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdateValue()
    {
        $this->lastUpdate = new \DateTime();
    }

    /**
     * @return ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param ArrayCollection $files
     * @return Project
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getUserHasRights()
    {
        return $this->userHasRights;
    }

    /**
     * @param boolean $userHasRights
     * @return Project
     */
    public function setUserHasRights($userHasRights)
    {
        $this->userHasRights = $userHasRights;

        return $this;
    }

}

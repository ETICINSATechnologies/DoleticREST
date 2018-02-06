<?php

namespace UABundle\Entity;

use JMS\Serializer\Annotation\SerializedName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="ua_task")
 * @ORM\Entity(repositoryClass="UABundle\Repository\TaskRepository")
 * @ORM\EntityListeners({ "UABundle\Listener\TaskListener" })
 */
class Task
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks"))
     */
    private $project;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
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
     * @var int
     *
     * @SerializedName("jehAmount")
     * @ORM\Column(name="jeh_amount", type="integer")
     */
    private $jehAmount;

    /**
     * @var int
     *
     * @SerializedName("jehCost")
     * @ORM\Column(name="jeh_cost", type="integer")
     */
    private $jehCost;

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
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="ended", type="boolean")
     */
    private $ended;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Delivery", mappedBy="task", fetch="EXTRA_LAZY")
     */
    private $deliveries;


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
     * @return Task
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
     * @return Task
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
     * @return Task
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
     * Set jehAmount
     *
     * @param integer $jehAmount
     * @return Task
     */
    public function setJehAmount($jehAmount)
    {
        $this->jehAmount = $jehAmount;

        return $this;
    }

    /**
     * Get jehAmount
     *
     * @return integer
     */
    public function getJehAmount()
    {
        return $this->jehAmount;
    }

    /**
     * Set jehCost
     *
     * @param integer $jehCost
     * @return Task
     */
    public function setJehCost($jehCost)
    {
        $this->jehCost = $jehCost;

        return $this;
    }

    /**
     * Get jehCost
     *
     * @return integer
     */
    public function getJehCost()
    {
        return $this->jehCost;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Task
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
     * @return Task
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
     * Set ended
     *
     * @param boolean $ended
     * @return Task
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return boolean
     */
    public function getEnded()
    {
        return $this->ended;
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
     * @return Task
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    /**
     * @param ArrayCollection $deliveries
     * @return Task
     */
    public function setDeliveries($deliveries)
    {
        $this->deliveries = $deliveries;

        return $this;
    }

}

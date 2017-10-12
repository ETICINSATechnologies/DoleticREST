<?php

namespace GRCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\User;

/**
 * ContactAction
 *
 * @ORM\Table(name="grc_contact_action")
 * @ORM\Entity(repositoryClass="GRCBundle\Repository\ContactActionRepository")
 */
class ContactAction
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var bool
     *
     * @ORM\Column(name="replied", type="boolean")
     */
    private $replied;

    /**
     * @var ContactActionType
     *
     * @ORM\ManyToOne(targetEntity="ContactActionType")
     */
    private $type;

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="actions")
     */
    private $contact;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="KernelBundle\Entity\User")
     */
    private $prospector;


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
     * Set date
     *
     * @param \DateTime $date
     * @return ContactAction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return ContactAction
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
     * Set replied
     *
     * @param boolean $replied
     * @return ContactAction
     */
    public function setReplied($replied)
    {
        $this->replied = $replied;

        return $this;
    }

    /**
     * Get replied
     *
     * @return boolean
     */
    public function getReplied()
    {
        return $this->replied;
    }

    /**
     * @return ContactActionType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ContactActionType $type
     * @return ContactAction
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return ContactAction
     */
    public function setProspector($prospector)
    {
        $this->prospector = $prospector;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return ContactAction
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

}

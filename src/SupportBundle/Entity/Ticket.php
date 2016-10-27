<?php

namespace SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use RHBundle\Entity\UserData;

/**
 * Ticket
 *
 * @ORM\Table(name="support_ticket")
 * @ORM\Entity(repositoryClass="SupportBundle\Repository\TicketRepository")
 * @ORM\EntityListeners({ "SupportBundle\Listener\TicketListener" })
 */
class Ticket
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var TicketType
     *
     * @ORM\ManyToOne(targetEntity="TicketType")
     */
    private $type;

    /**
     * @var TicketStatus
     *
     * @ORM\ManyToOne(targetEntity="TicketStatus")
     */
    private $status;

    /**
     * @var UserData
     *
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\UserData")
     */
    private $author;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="archived_since", type="datetime", nullable=true)
     */
    private $archivedSince;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

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
     * Set title
     *
     * @param string $title
     * @return Ticket
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Ticket
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return TicketType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TicketType $type
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param TicketStatus $status
     * @return Ticket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return UserData
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param UserData $author
     * @return Ticket
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     * @return Ticket
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getArchivedSince()
    {
        return $this->archivedSince;
    }

    /**
     * @param \DateTime $archivedSince
     * @return Ticket
     */
    public function setArchivedSince($archivedSince)
    {
        $this->archivedSince = $archivedSince;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return Ticket
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

}

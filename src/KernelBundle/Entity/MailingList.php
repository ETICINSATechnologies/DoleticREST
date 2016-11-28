<?php

namespace KernelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailingList
 *
 * @ORM\Table(name="kernel_mailing_list")
 * @ORM\Entity(repositoryClass="KernelBundle\Repository\MailingListRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "division" = "DivisionMailingList",
 *     "team" = "TeamMailingList",
 *     "position" = "PositionMailingList",
 *     "custom" = "CustomMailingList"
 * })
 */
abstract class MailingList
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
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_email", type="string", length=255)
     */
    private $ownerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="reply_to", type="string", length=255, nullable=true)
     */
    private $replyTo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="moderator_message", type="boolean")
     */
    private $moderatorMessage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="subscribe_by_moderator", type="boolean")
     */
    private $subscribeByModerator;

    /**
     * @var boolean
     *
     * @ORM\Column(name="users_post_only", type="boolean")
     */
    private $usersPostOnly;

    /**
     * @var boolean
     *
     * @ORM\Column(name="include_personal", type="boolean")
     */
    private $includePersonal;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return MailingList
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MailingList
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
     * @return string
     */
    public function getOwnerEmail()
    {
        return $this->ownerEmail;
    }

    /**
     * @param string $ownerEmail
     * @return MailingList
     */
    public function setOwnerEmail($ownerEmail)
    {
        $this->ownerEmail = $ownerEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param string $replyTo
     * @return MailingList
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isModeratorMessage()
    {
        return $this->moderatorMessage;
    }

    /**
     * @param boolean $moderatorMessage
     * @return MailingList
     */
    public function setModeratorMessage($moderatorMessage)
    {
        $this->moderatorMessage = $moderatorMessage;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSubscribeByModerator()
    {
        return $this->subscribeByModerator;
    }

    /**
     * @param boolean $subscribeByModerator
     * @return MailingList
     */
    public function setSubscribeByModerator($subscribeByModerator)
    {
        $this->subscribeByModerator = $subscribeByModerator;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUsersPostOnly()
    {
        return $this->usersPostOnly;
    }

    /**
     * @param boolean $usersPostOnly
     * @return MailingList
     */
    public function setUsersPostOnly($usersPostOnly)
    {
        $this->usersPostOnly = $usersPostOnly;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIncludePersonal()
    {
        return $this->includePersonal;
    }

    /**
     * @param boolean $includePersonal
     * @return MailingList
     */
    public function setIncludePersonal($includePersonal)
    {
        $this->includePersonal = $includePersonal;

        return $this;
    }

}


<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GRCBundle\Entity\Contact;

/**
 * ProjectContact
 *
 * @ORM\Table(name="ua_project_contact", uniqueConstraints={@ORM\UniqueConstraint(name="contact", columns={"project_id", "contact_id"})})
 * @ORM\Entity(repositoryClass="UABundle\Repository\ProjectContactRepository")
 */
class ProjectContact
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="contacts")
     *
     */
    private $project;

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="GRCBundle\Entity\Contact")
     *
     */
    private $contact;


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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return ProjectContact
     */
    public function setProject($project)
    {
        $this->project = $project;
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
     * @return ProjectContact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

}

<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectContact
 *
 * @ORM\Table(name="ua_project_contact")
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
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="contacts")
     *
     */
    private $project;

    /**
     * @var array
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
     * @return array
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param array $project
     * @return ProjectContact
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return array
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param array $contact
     * @return ProjectContact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

}

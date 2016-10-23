<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amendment
 *
 * @ORM\Table(name="ua_amendment")
 * @ORM\Entity(repositoryClass="UABundle\Repository\AmendmentRepository")
 */
class Amendment
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="amendments"))
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="attributable", type="boolean")
     */
    private $attributable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


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
     * Set content
     *
     * @param string $content
     * @return Amendment
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
     * Set attributable
     *
     * @param boolean $attributable
     * @return Amendment
     */
    public function setAttributable($attributable)
    {
        $this->attributable = $attributable;

        return $this;
    }

    /**
     * Get attributable
     *
     * @return boolean
     */
    public function getAttributable()
    {
        return $this->attributable;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Amendment
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Amendment
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

}

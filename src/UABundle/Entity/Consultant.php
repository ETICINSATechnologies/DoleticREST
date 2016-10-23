<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuth2ServiceBundle\Tests\Storage\User;
use RHBundle\Entity\UserData;

/**
 * Consultant
 *
 * @ORM\Table(name="ua_consultant")
 * @ORM\Entity(repositoryClass="UABundle\Repository\ConsultantRepository")
 */
class Consultant
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
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="consultants"))
     */
    private $project;

    /**
     * @var UserData
     *
     * @ORM\ManyToOne(targetEntity="RHBundle\Entity\UserData")
     */
    private $userData;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="jeh_assigned", type="integer")
     */
    private $jehAssigned;

    /**
     * @var int
     *
     * @ORM\Column(name="pay_by_jeh", type="integer")
     */
    private $payByJeh;


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
     * @return Consultant
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
     * Set jehAssigned
     *
     * @param integer $jehAssigned
     * @return Consultant
     */
    public function setJehAssigned($jehAssigned)
    {
        $this->jehAssigned = $jehAssigned;

        return $this;
    }

    /**
     * Get jehAssigned
     *
     * @return integer
     */
    public function getJehAssigned()
    {
        return $this->jehAssigned;
    }

    /**
     * Set payByJeh
     *
     * @param integer $payByJeh
     * @return Consultant
     */
    public function setPayByJeh($payByJeh)
    {
        $this->payByJeh = $payByJeh;

        return $this;
    }

    /**
     * Get payByJeh
     *
     * @return integer
     */
    public function getPayByJeh()
    {
        return $this->payByJeh;
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
     * @return Consultant
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return UserData
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @param UserData $userData
     * @return Consultant
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;

        return $this;
    }

}

<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsultantDocument
 *
 * @ORM\Entity(repositoryClass="UABundle\Repository\ConsultantDocumentRepository")
 */
class ConsultantDocument extends Document
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
     * @var Consultant
     *
     * @ORM\ManyToOne(targetEntity="Consultant", inversedBy="documents"))
     */
    private $consultant;


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
     * @return Consultant
     */
    public function getConsultant()
    {
        return $this->consultant;
    }

    /**
     * @param Consultant $consultant
     * @return ConsultantDocument
     */
    public function setConsultant($consultant)
    {
        $this->consultant = $consultant;

        return $this;
    }

}

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
     * @var Consultant
     *
     * @ORM\ManyToOne(targetEntity="Consultant", inversedBy="documents"))
     */
    private $consultant;

    /**
     * @var ConsultantDocumentTemplate
     *
     * @ORM\ManyToOne(targetEntity="UABundle\Entity\ConsultantDocumentTemplate")
     */
    private $template;

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

    /**
     * @return ConsultantDocumentTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param ConsultantDocumentTemplate $template
     * @return ConsultantDocument
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

}

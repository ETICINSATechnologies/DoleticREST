<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeliveryDocument
 *
 * @ORM\Entity(repositoryClass="UABundle\Repository\DeliveryDocumentRepository")
 */
class DeliveryDocument extends Document
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
     * @var Delivery
     *
     * @ORM\ManyToOne(targetEntity="Delivery", inversedBy="documents"))
     */
    private $delivery;

    /**
     * @var DeliveryDocumentTemplate
     *
     * @ORM\ManyToOne(targetEntity="UABundle\Entity\DeliveryDocumentTemplate")
     */
    private $template;


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
     * @return Delivery
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param Delivery $delivery
     * @return DeliveryDocument
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return DeliveryDocumentTemplate
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param DeliveryDocumentTemplate $template
     * @return DeliveryDocument
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }


}

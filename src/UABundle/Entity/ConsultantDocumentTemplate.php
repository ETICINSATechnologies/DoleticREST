<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\DocumentTemplate;

/**
 * ProjectDocument
 *
 * @ORM\Entity(repositoryClass="UABundle\Repository\ConsultantDocumentTemplateRepository")
 */
class ConsultantDocumentTemplate extends DocumentTemplate
{
}

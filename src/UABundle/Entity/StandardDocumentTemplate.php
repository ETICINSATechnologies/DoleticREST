<?php

namespace UABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KernelBundle\Entity\DocumentTemplate;

/**
 * ProjectDocument
 *
 * @ORM\Entity(repositoryClass="UABundle\Repository\StandardDocumentTemplateRepository")
 *
 */
class StandardDocumentTemplate extends DocumentTemplate
{
}

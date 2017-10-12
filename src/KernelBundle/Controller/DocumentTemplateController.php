<?php

namespace KernelBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Form\DocumentTemplateType;

class DocumentTemplateController extends FOSRestController
{

    /**
     * Get all the templates
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get all templates",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/templates")
     */
    public function getDocumentTemplatesAction()
    {

        $templates = $this->getDoctrine()->getRepository("KernelBundle:DocumentTemplate")
            ->findAll();

        return array('templates' => $templates);
    }

    /**
     * Get a template by ID
     * @param DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a template",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("template", class="KernelBundle:DocumentTemplate")
     * @Get("/template/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentTemplateAction(DocumentTemplate $template)
    {

        return array('template' => $template);

    }

    /**
     * Get a template by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a template",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/template/{label}")
     */
    public function getDocumentTemplateByLabelAction($label)
    {

        $template = $this->getDoctrine()->getRepository('KernelBundle:DocumentTemplate')->findOneBy(['label' => $label]);
        return array('template' => $template);

    }

    /**
     * Delete a DocumentTemplate
     * Delete action
     * @var DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Delete a DocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("template", class="KernelBundle:DocumentTemplate")
     * @Delete("/template/{id}", requirements={"id" = "\d+"})
     */
    public function deleteDocumentTemplateAction(DocumentTemplate $template)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($template);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ConsultantDocumentTemplate;
use UABundle\Entity\Consultant;
use UABundle\Form\ConsultantDocumentTemplateType;

class ConsultantDocumentTemplateController extends FOSRestController
{

    /**
     * Get all the consultant_document_templates
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocumentTemplate",
     *  description="Get all consultant_document_templates",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/consultant_document_templates")
     */
    public function getConsultantDocumentTemplatesAction()
    {

        $consultant_document_templates = $this->getDoctrine()->getRepository("UABundle:ConsultantDocumentTemplate")
            ->findAll();

        return array('consultant_document_templates' => $consultant_document_templates);
    }

    /**
     * Get a consultant_document_template by ID
     * @param ConsultantDocumentTemplate $consultant_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocumentTemplate",
     *  description="Get a consultant_document_template",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_document_template", class="UABundle:ConsultantDocumentTemplate")
     * @Get("/consultant_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantDocumentTemplateAction(ConsultantDocumentTemplate $consultant_document_template)
    {

        return array('consultant_document_template' => $consultant_document_template);

    }

    /**
     * Create a new ConsultantDocumentTemplate
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ConsultantDocumentTemplate",
     *  description="Create a new ConsultantDocumentTemplate",
     *  input="UABundle\Form\ConsultantDocumentTemplateType",
     *  output="UABundle\Entity\ConsultantDocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/consultant_document_template")
     */
    public function postConsultantDocumentTemplateAction(Request $request)
    {
        $consultant_document_template = new ConsultantDocumentTemplate();
        $form = $this->createForm(new ConsultantDocumentTemplateType(), $consultant_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant_document_template);
            $em->flush();

            return array("consultant_document_template" => $consultant_document_template);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ConsultantDocumentTemplate
     * Put action
     * @var Request $request
     * @var ConsultantDocumentTemplate $consultant_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocumentTemplate",
     *  description="Edit a ConsultantDocumentTemplate",
     *  input="UABundle\Form\ConsultantDocumentTemplateType",
     *  output="UABundle\Entity\ConsultantDocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_document_template", class="UABundle:ConsultantDocumentTemplate")
     * @Post("/consultant_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function putConsultantDocumentTemplateAction(Request $request, ConsultantDocumentTemplate $consultant_document_template)
    {
        $form = $this->createForm(new ConsultantDocumentTemplateType(), $consultant_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant_document_template);
            $em->flush();

            return array("consultant_document_template" => $consultant_document_template);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ConsultantDocumentTemplate
     * Delete action
     * @var ConsultantDocumentTemplate $consultant_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocumentTemplate",
     *  description="Delete a ConsultantDocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_document_template", class="UABundle:ConsultantDocumentTemplate")
     * @Delete("/consultant_document_template/{id}")
     */
    public function deleteConsultantDocumentTemplateAction(ConsultantDocumentTemplate $consultant_document_template)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant_document_template);
        $em->flush();

        return array("status" => "Deleted");
    }

}
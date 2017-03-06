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
use UABundle\Entity\DeliveryDocumentTemplate;
use UABundle\Entity\Delivery;
use UABundle\Form\DeliveryDocumentTemplateType;

class DeliveryDocumentTemplateController extends FOSRestController
{

    /**
     * Get all the delivery_document_templates
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocumentTemplate",
     *  description="Get all delivery_document_templates",
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
     * @Get("/delivery_document_templates")
     */
    public function getDeliveryDocumentTemplatesAction()
    {

        $delivery_document_templates = $this->getDoctrine()->getRepository("UABundle:DeliveryDocumentTemplate")
            ->findAll();

        return array('delivery_document_templates' => $delivery_document_templates);
    }

    /**
     * Get a delivery_document_template by ID
     * @param DeliveryDocumentTemplate $delivery_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocumentTemplate",
     *  description="Get a delivery_document_template",
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
     * @ParamConverter("delivery_document_template", class="UABundle:DeliveryDocumentTemplate")
     * @Get("/delivery_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentTemplateAction(DeliveryDocumentTemplate $delivery_document_template)
    {

        return array('delivery_document_template' => $delivery_document_template);

    }

    /**
     * Create a new DeliveryDocumentTemplate
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="DeliveryDocumentTemplate",
     *  description="Create a new DeliveryDocumentTemplate",
     *  input="UABundle\Form\DeliveryDocumentTemplateType",
     *  output="UABundle\Entity\DeliveryDocumentTemplate",
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
     * @Post("/delivery_document_template")
     */
    public function postDeliveryDocumentTemplateAction(Request $request)
    {
        $delivery_document_template = new DeliveryDocumentTemplate();
        $form = $this->createForm(new DeliveryDocumentTemplateType(), $delivery_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($delivery_document_template);
            $em->flush();

            return array("delivery_document_template" => $delivery_document_template);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a DeliveryDocumentTemplate
     * Put action
     * @var Request $request
     * @var DeliveryDocumentTemplate $delivery_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocumentTemplate",
     *  description="Edit a DeliveryDocumentTemplate",
     *  input="UABundle\Form\DeliveryDocumentTemplateType",
     *  output="UABundle\Entity\DeliveryDocumentTemplate",
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
     * @ParamConverter("delivery_document_template", class="UABundle:DeliveryDocumentTemplate")
     * @Post("/delivery_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function putDeliveryDocumentTemplateAction(Request $request, DeliveryDocumentTemplate $delivery_document_template)
    {
        $form = $this->createForm(new DeliveryDocumentTemplateType(), $delivery_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($delivery_document_template);
            $em->flush();

            return array("delivery_document_template" => $delivery_document_template);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a DeliveryDocumentTemplate
     * Delete action
     * @var DeliveryDocumentTemplate $delivery_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocumentTemplate",
     *  description="Delete a DeliveryDocumentTemplate",
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
     * @ParamConverter("delivery_document_template", class="UABundle:DeliveryDocumentTemplate")
     * @Delete("/delivery_document_template/{id}")
     */
    public function deleteDeliveryDocumentTemplateAction(DeliveryDocumentTemplate $delivery_document_template)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($delivery_document_template);
        $em->flush();

        return array("status" => "Deleted");
    }

}
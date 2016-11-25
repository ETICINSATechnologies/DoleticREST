<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\DeliveryDocumentTemplate;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\DeliveryDocument;
use UABundle\Entity\Delivery;
use UABundle\Form\DeliveryDocumentType;

class DeliveryDocumentController extends FOSRestController
{

    /**
     * Get all the delivery_documents
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get all delivery_documents",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/delivery_documents")
     */
    public function getDeliveryDocumentsAction()
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findAll();

        return array('delivery_documents' => $delivery_documents);
    }

    /**
     * Get all the delivery_documents in a delivery
     * @param Delivery $delivery
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get all delivery_documents in a delivery",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("delivery", class="UABundle:Delivery")
     * @Get("/delivery_documents/delivery/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentsByDeliveryAction(Delivery $delivery)
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findBy(['delivery' => $delivery]);

        return array('delivery_documents' => $delivery_documents);
    }

    /**
     * Get all the delivery_documents from a template
     * @param DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get all delivery_documents from a template",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("template", class="KernelBundle:DocumentTemplate")
     * @Get("/delivery_documents/template/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentsByTemplateAction(DocumentTemplate $template)
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findBy(['template' => $template]);

        return array('delivery_documents' => $delivery_documents);
    }

    /**
     * Get all the delivery_documents validated by a user
     * @param User $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get all delivery_documents validated by a user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("auditor", class="KernelBundle:User")
     * @Get("/delivery_documents/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentsByAuditorAction(User $auditor)
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findBy(['auditor' => $auditor]);

        return array('delivery_documents' => $delivery_documents);
    }

    /**
     * Get all the delivery_documents validated by the current user
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get all delivery_documents validated by the current user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/delivery_documents/auditor/current")
     */
    public function getCurrentUserAuditedDeliveryDocumentsAction()
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findBy(['auditor' => $this->getUser()]);

        return array('delivery_documents' => $delivery_documents);
    }

    /**
     * Get a delivery_document by ID
     * @param DeliveryDocument $delivery_document
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get a delivery_document",
     *  requirements={
     *      {
     *          "name"="delivery_document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="delivery_document id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Get("/delivery_document/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentAction(DeliveryDocument $delivery_document)
    {

        return array('delivery_document' => $delivery_document);

    }

    /**
     * Create a new DeliveryDocument
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Create a new DeliveryDocument",
     *  input="UABundle\Form\DeliveryDocumentType",
     *  output="UABundle\Entity\DeliveryDocument",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @Post("/delivery_document")
     */
    public function postDeliveryDocumentAction(Request $request)
    {
        $delivery_document = new DeliveryDocument();
        $form = $this->createForm(new DeliveryDocumentType(), $delivery_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($delivery_document);
            $em->flush();

            return array("delivery_document" => $delivery_document);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a DeliveryDocument
     * Put action
     * @var Request $request
     * @var DeliveryDocument $delivery_document
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Edit a DeliveryDocument",
     *  requirements={
     *      {
     *          "name"="delivery_document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="delivery_document id"
     *      }
     *  },
     *  input="UABundle\Form\DeliveryDocumentType",
     *  output="UABundle\Entity\DeliveryDocument",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Post("/delivery_document/{id}")
     */
    public function putDeliveryDocumentAction(Request $request, DeliveryDocument $delivery_document)
    {
        $form = $this->createForm(new DeliveryDocumentType(), $delivery_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($delivery_document);
            $em->flush();

            return array("delivery_document" => $delivery_document);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a DeliveryDocument
     * Delete action
     * @var DeliveryDocument $delivery_document
     * @return array
     *
     * @View()
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Delete("/delivery_document/{id}")
     */
    public function deleteDeliveryDocumentAction(DeliveryDocument $delivery_document)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($delivery_document);
        $em->flush();

        return array("status" => "Deleted");
    }

}
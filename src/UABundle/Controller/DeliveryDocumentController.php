<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use UABundle\Entity\DeliveryDocumentTemplate;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($delivery_documents as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the delivery_documents from a template
     * @param DeliveryDocumentTemplate $template
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("template", class="KernelBundle:DocumentTemplate")
     * @Get("/delivery_documents/template/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentsByTemplateAction(DeliveryDocumentTemplate $template)
    {

        $delivery_documents = $this->getDoctrine()->getRepository("UABundle:DeliveryDocument")
            ->findBy(['template' => $template]);

        $array = [];
        foreach ($delivery_documents as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($delivery_documents as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($delivery_documents as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a delivery_document by ID
     * @param DeliveryDocument $delivery_document
     * @return array
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Get a delivery_document",
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
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Get("/delivery_document/{id}", requirements={"id" = "\d+"})
     */
    public function getDeliveryDocumentAction(DeliveryDocument $delivery_document)
    {

        return $delivery_document;

    }


    /**
     * Download the file attached to a project_document by ID
     * @param DeliveryDocument $delivery_document
     * @return BinaryFileResponse
     *
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Download the file attached to a delivery_document",
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
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Get("/delivery_document/{id}/download", requirements={"id" = "\d+"})
     */
    public function downloadDeliveryDocumentAction(DeliveryDocument $delivery_document)
    {
        $fileName = $delivery_document->getFile();

        $response = new BinaryFileResponse($fileName);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
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
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
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

        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $delivery_document->getDelivery()->getTask()->getProject())) {
            throw new AccessDeniedException();
        }

        if ($form->isValid()) {
            $delivery_document->setValid(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($delivery_document);
            $em->flush();

            return $delivery_document;

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
     *  input="UABundle\Form\DeliveryDocumentType",
     *  output="UABundle\Entity\DeliveryDocument",
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
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Post("/delivery_document/{id}", requirements={"id" = "\d+"})
     */
    public function putDeliveryDocumentAction(Request $request, DeliveryDocument $delivery_document)
    {
        $form = $this->createForm(new DeliveryDocumentType(), $delivery_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $delivery_document->getDelivery()->getTask()->getProject())) {
                throw new AccessDeniedException();
            }

            // Invalidate the document, since it's a different file
            $delivery_document->setValid(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($delivery_document);
            $em->flush();

            return $delivery_document;
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
     * @ApiDoc(
     *  section="DeliveryDocument",
     *  description="Delete a DeliveryDocument",
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
     * @ParamConverter("delivery_document", class="UABundle:DeliveryDocument")
     * @Delete("/delivery_document/{id}", requirements={"id" = "\d+"})
     */
    public function deleteDeliveryDocumentAction(DeliveryDocument $delivery_document)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $delivery_document->getDelivery()->getTask()->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($delivery_document);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\ConsultantDocumentTemplate;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ConsultantDocument;
use UABundle\Entity\Consultant;
use UABundle\Form\ConsultantDocumentType;

class ConsultantDocumentController extends FOSRestController
{

    /**
     * Get all the consultant_documents
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get all consultant_documents",
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
     * @Get("/consultant_documents")
     */
    public function getConsultantDocumentsAction()
    {

        $consultant_documents = $this->getDoctrine()->getRepository("UABundle:ConsultantDocument")
            ->findAll();

        return array('consultant_documents' => $consultant_documents);
    }

    /**
     * Get all the consultant_documents in a consultant
     * @param Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get all consultant_documents in a consultant",
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Get("/consultant_documents/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantDocumentsByConsultantAction(Consultant $consultant)
    {

        $consultant_documents = $this->getDoctrine()->getRepository("UABundle:ConsultantDocument")
            ->findBy(['consultant' => $consultant]);

        return array('consultant_documents' => $consultant_documents);
    }

    /**
     * Get all the consultant_documents from a template
     * @param DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get all consultant_documents from a template",
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
     * @Get("/consultant_documents/template/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantDocumentsByTemplateAction(DocumentTemplate $template)
    {

        $consultant_documents = $this->getDoctrine()->getRepository("UABundle:ConsultantDocument")
            ->findBy(['template' => $template]);

        return array('consultant_documents' => $consultant_documents);
    }

    /**
     * Get all the consultant_documents validated by a user
     * @param User $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get all consultant_documents validated by a user",
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
     * @Get("/consultant_documents/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantDocumentsByAuditorAction(User $auditor)
    {

        $consultant_documents = $this->getDoctrine()->getRepository("UABundle:ConsultantDocument")
            ->findBy(['auditor' => $auditor]);

        return array('consultant_documents' => $consultant_documents);
    }

    /**
     * Get all the consultant_documents validated by the current user
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get all consultant_documents validated by the current user",
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
     * @Get("/consultant_documents/auditor/current")
     */
    public function getCurrentUserAuditedConsultantDocumentsAction()
    {

        $consultant_documents = $this->getDoctrine()->getRepository("UABundle:ConsultantDocument")
            ->findBy(['auditor' => $this->getUser()]);

        return array('consultant_documents' => $consultant_documents);
    }

    /**
     * Get a consultant_document by ID
     * @param ConsultantDocument $consultant_document
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Get a consultant_document",
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
     * @ParamConverter("consultant_document", class="UABundle:ConsultantDocument")
     * @Get("/consultant_document/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantDocumentAction(ConsultantDocument $consultant_document)
    {

        return array('consultant_document' => $consultant_document);

    }

    /**
     * Create a new ConsultantDocument
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Create a new ConsultantDocument",
     *  input="UABundle\Form\ConsultantDocumentType",
     *  output="UABundle\Entity\ConsultantDocument",
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
     * @Post("/consultant_document")
     */
    public function postConsultantDocumentAction(Request $request)
    {
        $consultant_document = new ConsultantDocument();
        $form = $this->createForm(new ConsultantDocumentType(), $consultant_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant_document);
            $em->flush();

            return array("consultant_document" => $consultant_document);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ConsultantDocument
     * Put action
     * @var Request $request
     * @var ConsultantDocument $consultant_document
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Edit a ConsultantDocument",
     *  input="UABundle\Form\ConsultantDocumentType",
     *  output="UABundle\Entity\ConsultantDocument",
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
     * @ParamConverter("consultant_document", class="UABundle:ConsultantDocument")
     * @Post("/consultant_document/{id}", requirements={"id" = "\d+"})
     */
    public function putConsultantDocumentAction(Request $request, ConsultantDocument $consultant_document)
    {
        $form = $this->createForm(new ConsultantDocumentType(), $consultant_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant_document);
            $em->flush();

            return array("consultant_document" => $consultant_document);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ConsultantDocument
     * Delete action
     * @var ConsultantDocument $consultant_document
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantDocument",
     *  description="Delete a ConsultantDocument",
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
     * @ParamConverter("consultant_document", class="UABundle:ConsultantDocument")
     * @Delete("/consultant_document/{id}", requirements={"id" = "\d+"})
     */
    public function deleteConsultantDocumentAction(ConsultantDocument $consultant_document)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant_document);
        $em->flush();

        return array("status" => "Deleted");
    }

}
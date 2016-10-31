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
use UABundle\Entity\Document;
use UABundle\Entity\Project;
use UABundle\Form\DocumentType;

class DocumentController extends FOSRestController
{

    /**
     * Get all the documents
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all documents",
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
     * @Get("/documents")
     */
    public function getDocumentsAction()
    {

        $documents = $this->getDoctrine()->getRepository("UABundle:Document")
            ->findAll();

        return array('documents' => $documents);
    }

    /**
     * Get all the documents in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all documents in a project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/documents/project/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentsByProjectAction(Project $project)
    {

        $documents = $this->getDoctrine()->getRepository("UABundle:Document")
            ->findBy(['project' => $project]);

        return array('documents' => $documents);
    }

    /**
     * Get all the documents from a template
     * @param DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all documents from a template",
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
     * @Get("/documents/template/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentsByTemplateAction(DocumentTemplate $template)
    {

        $documents = $this->getDoctrine()->getRepository("UABundle:Document")
            ->findBy(['template' => $template]);

        return array('documents' => $documents);
    }

    /**
     * Get all the documents validated by a user
     * @param User $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all documents validated by a user",
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
     * @Get("/documents/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentsByAuditorAction(User $auditor)
    {

        $documents = $this->getDoctrine()->getRepository("UABundle:Document")
            ->findBy(['auditor' => $auditor]);

        return array('documents' => $documents);
    }

    /**
     * Get all the documents validated by the current user
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all documents validated by the current user",
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
     * @Get("/documents/auditor/current")
     */
    public function getCurrentUserAuditedDocumentsAction()
    {

        $documents = $this->getDoctrine()->getRepository("UABundle:Document")
            ->findBy(['auditor' => $this->getUser()]);

        return array('documents' => $documents);
    }

    /**
     * Get a document by ID
     * @param Document $document
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get a document",
     *  requirements={
     *      {
     *          "name"="document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="document id"
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
     * @ParamConverter("document", class="UABundle:Document")
     * @Get("/document/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentAction(Document $document)
    {

        return array('document' => $document);

    }

    /**
     * Create a new Document
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Create a new Document",
     *  input="UABundle\Form\DocumentType",
     *  output="UABundle\Entity\Document",
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
     * @Post("/document")
     */
    public function postDocumentAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm(new DocumentType(), $document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();

            return array("document" => $document);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Document
     * Put action
     * @var Request $request
     * @var Document $document
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Edit a Document",
     *  requirements={
     *      {
     *          "name"="document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="document id"
     *      }
     *  },
     *  input="UABundle\Form\DocumentType",
     *  output="UABundle\Entity\Document",
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
     * @ParamConverter("document", class="UABundle:Document")
     * @Post("/document/{id}")
     */
    public function putDocumentAction(Request $request, Document $document)
    {
        $form = $this->createForm(new DocumentType(), $document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            return array("document" => $document);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Document
     * Delete action
     * @var Document $document
     * @return array
     *
     * @View()
     * @ParamConverter("document", class="UABundle:Document")
     * @Delete("/document/{id}")
     */
    public function deleteDocumentAction(Document $document)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($document);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\ProjectDocumentTemplate;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ProjectDocument;
use UABundle\Entity\Project;
use UABundle\Form\ProjectDocumentType;

class ProjectDocumentController extends FOSRestController
{

    /**
     * Get all the project_documents
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get all project_documents",
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
     * @Get("/project_documents")
     */
    public function getProjectDocumentsAction()
    {

        $project_documents = $this->getDoctrine()->getRepository("UABundle:ProjectDocument")
            ->findAll();

        return array('project_documents' => $project_documents);
    }

    /**
     * Get all the project_documents in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get all project_documents in a project",
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
     * @Get("/project_documents/project/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectDocumentsByProjectAction(Project $project)
    {

        $project_documents = $this->getDoctrine()->getRepository("UABundle:ProjectDocument")
            ->findBy(['project' => $project]);

        return array('project_documents' => $project_documents);
    }

    /**
     * Get all the project_documents from a template
     * @param DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get all project_documents from a template",
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
     * @Get("/project_documents/template/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectDocumentsByTemplateAction(DocumentTemplate $template)
    {

        $project_documents = $this->getDoctrine()->getRepository("UABundle:ProjectDocument")
            ->findBy(['template' => $template]);

        return array('project_documents' => $project_documents);
    }

    /**
     * Get all the project_documents validated by a user
     * @param User $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get all project_documents validated by a user",
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
     * @Get("/project_documents/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectDocumentsByAuditorAction(User $auditor)
    {

        $project_documents = $this->getDoctrine()->getRepository("UABundle:ProjectDocument")
            ->findBy(['auditor' => $auditor]);

        return array('project_documents' => $project_documents);
    }

    /**
     * Get all the project_documents validated by the current user
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get all project_documents validated by the current user",
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
     * @Get("/project_documents/auditor/current")
     */
    public function getCurrentUserAuditedProjectDocumentsAction()
    {

        $project_documents = $this->getDoctrine()->getRepository("UABundle:ProjectDocument")
            ->findBy(['auditor' => $this->getUser()]);

        return array('project_documents' => $project_documents);
    }

    /**
     * Get a project_document by ID
     * @param ProjectDocument $project_document
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Get a project_document",
     *  requirements={
     *      {
     *          "name"="project_document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_document id"
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
     * @ParamConverter("project_document", class="UABundle:ProjectDocument")
     * @Get("/project_document/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectDocumentAction(ProjectDocument $project_document)
    {

        return array('project_document' => $project_document);

    }

    /**
     * Create a new ProjectDocument
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Create a new ProjectDocument",
     *  input="UABundle\Form\ProjectDocumentType",
     *  output="UABundle\Entity\ProjectDocument",
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
     * @Post("/project_document")
     */
    public function postProjectDocumentAction(Request $request)
    {
        $project_document = new ProjectDocument();
        $form = $this->createForm(new ProjectDocumentType(), $project_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_document);
            $em->flush();

            return array("project_document" => $project_document);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectDocument
     * Put action
     * @var Request $request
     * @var ProjectDocument $project_document
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocument",
     *  description="Edit a ProjectDocument",
     *  requirements={
     *      {
     *          "name"="project_document",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_document id"
     *      }
     *  },
     *  input="UABundle\Form\ProjectDocumentType",
     *  output="UABundle\Entity\ProjectDocument",
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
     * @ParamConverter("project_document", class="UABundle:ProjectDocument")
     * @Post("/project_document/{id}")
     */
    public function putProjectDocumentAction(Request $request, ProjectDocument $project_document)
    {
        $form = $this->createForm(new ProjectDocumentType(), $project_document);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_document);
            $em->flush();

            return array("project_document" => $project_document);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectDocument
     * Delete action
     * @var ProjectDocument $project_document
     * @return array
     *
     * @View()
     * @ParamConverter("project_document", class="UABundle:ProjectDocument")
     * @Delete("/project_document/{id}")
     */
    public function deleteProjectDocumentAction(ProjectDocument $project_document)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_document);
        $em->flush();

        return array("status" => "Deleted");
    }

}
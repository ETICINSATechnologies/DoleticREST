<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Entity\ProjectDocumentTemplateTemplate;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ProjectDocumentTemplate;
use UABundle\Entity\Project;
use UABundle\Form\ProjectDocumentTemplateType;

class ProjectDocumentTemplateController extends FOSRestController
{

    /**
     * Get all the project_document_templates
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocumentTemplate",
     *  description="Get all project_document_templates",
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
     * @Get("/project_document_templates")
     */
    public function getProjectDocumentTemplatesAction()
    {

        $project_document_templates = $this->getDoctrine()->getRepository("UABundle:ProjectDocumentTemplate")
            ->findAll();

        return array('project_document_templates' => $project_document_templates);
    }

    /**
     * Get a project_document_template by ID
     * @param ProjectDocumentTemplate $project_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocumentTemplate",
     *  description="Get a project_document_template",
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
     * @ParamConverter("project_document_template", class="UABundle:ProjectDocumentTemplate")
     * @Get("/project_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectDocumentTemplateAction(ProjectDocumentTemplate $project_document_template)
    {

        return array('project_document_template' => $project_document_template);

    }

    /**
     * Create a new ProjectDocumentTemplate
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectDocumentTemplate",
     *  description="Create a new ProjectDocumentTemplate",
     *  input="UABundle\Form\ProjectDocumentTemplateType",
     *  output="UABundle\Entity\ProjectDocumentTemplate",
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
     * @Post("/project_document_template")
     */
    public function postProjectDocumentTemplateAction(Request $request)
    {
        $project_document_template = new ProjectDocumentTemplate();
        $form = $this->createForm(new ProjectDocumentTemplateType(), $project_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_document_template);
            $em->flush();

            return array("project_document_template" => $project_document_template);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectDocumentTemplate
     * Put action
     * @var Request $request
     * @var ProjectDocumentTemplate $project_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocumentTemplate",
     *  description="Edit a ProjectDocumentTemplate",
     *  input="UABundle\Form\ProjectDocumentTemplateType",
     *  output="UABundle\Entity\ProjectDocumentTemplate",
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
     * @ParamConverter("project_document_template", class="UABundle:ProjectDocumentTemplate")
     * @Post("/project_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function putProjectDocumentTemplateAction(Request $request, ProjectDocumentTemplate $project_document_template)
    {
        $form = $this->createForm(new ProjectDocumentTemplateType(), $project_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_document_template);
            $em->flush();

            return array("project_document_template" => $project_document_template);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectDocumentTemplate
     * Delete action
     * @var ProjectDocumentTemplate $project_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectDocumentTemplate",
     *  description="Delete a ProjectDocumentTemplate",
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
     * @ParamConverter("project_document_template", class="UABundle:ProjectDocumentTemplate")
     * @Delete("/project_document_template/{id}")
     */
    public function deleteProjectDocumentTemplateAction(ProjectDocumentTemplate $project_document_template)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_document_template);
        $em->flush();

        return array("status" => "Deleted");
    }

}
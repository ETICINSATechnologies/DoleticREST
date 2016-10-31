<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ProjectField;
use UABundle\Form\ProjectFieldType;

class ProjectFieldController extends FOSRestController
{

    /**
     * Get all the project_fields
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectField",
     *  description="Get all project_fields",
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
     * @Get("/project_fields")
     */
    public function getProjectFieldsAction()
    {

        $project_fields = $this->getDoctrine()->getRepository("UABundle:ProjectField")
            ->findAll();

        return array('project_fields' => $project_fields);
    }

    /**
     * Get a project_field by ID
     * @param ProjectField $project_field
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectField",
     *  description="Get a project_field",
     *  requirements={
     *      {
     *          "name"="project_field",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_field id"
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
     * @ParamConverter("project_field", class="UABundle:ProjectField")
     * @Get("/project_field/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectFieldAction(ProjectField $project_field)
    {

        return array('project_field' => $project_field);

    }

    /**
     * Get a project_field by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectField",
     *  description="Get a project_field",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_field label"
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
     * @Get("/project_field/{label}")
     */
    public function getProjectFieldByLabelAction($label)
    {

        $project_field = $this->getDoctrine()->getRepository('UABundle:ProjectField')->findOneBy(['label' => $label]);
        return array('project_field' => $project_field);
    }

    /**
     * Create a new ProjectField
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectField",
     *  description="Create a new ProjectField",
     *  input="UABundle\Form\ProjectFieldType",
     *  output="UABundle\Entity\ProjectField",
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
     * @Post("/project_field")
     */
    public function postProjectFieldAction(Request $request)
    {
        $project_field = new ProjectField();
        $form = $this->createForm(new ProjectFieldType(), $project_field);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_field);
            $em->flush();

            return array("project_field" => $project_field);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectField
     * Put action
     * @var Request $request
     * @var ProjectField $project_field
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectField",
     *  description="Edit a ProjectField",
     *  requirements={
     *      {
     *          "name"="project_field",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_field id"
     *      }
     *  },
     *  input="UABundle\Form\ProjectFieldType",
     *  output="UABundle\Entity\ProjectField",
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
     * @ParamConverter("project_field", class="UABundle:ProjectField")
     * @Post("/project_field/{id}")
     */
    public function putProjectFieldAction(Request $request, ProjectField $project_field)
    {
        $form = $this->createForm(new ProjectFieldType(), $project_field);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_field);
            $em->flush();

            return array("project_field" => $project_field);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectField
     * Delete action
     * @var ProjectField $project_field
     * @return array
     *
     * @View()
     * @ParamConverter("project_field", class="UABundle:ProjectField")
     * @Delete("/project_field/{id}")
     */
    public function deleteProjectFieldAction(ProjectField $project_field)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_field);
        $em->flush();

        return array("status" => "Deleted");
    }

}
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
use UABundle\Entity\ProjectStatus;
use UABundle\Form\ProjectStatusType;

class ProjectStatusController extends FOSRestController
{

    /**
     * Get all the project_statuses
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Get all project_statuses",
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
     * @Get("/project_statuses")
     */
    public function getProjectStatusesAction()
    {

        $project_statuses = $this->getDoctrine()->getRepository("UABundle:ProjectStatus")
            ->findAll();

        return array('project_statuses' => $project_statuses);
    }

    /**
     * Get a project_status by ID
     * @param ProjectStatus $project_status
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Get a project_status",
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
     * @ParamConverter("project_status", class="UABundle:ProjectStatus")
     * @Get("/project_status/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectStatusAction(ProjectStatus $project_status)
    {

        return array('project_status' => $project_status);

    }

    /**
     * Get a project_status by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Get a project_status",
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
     * @Get("/project_status/{label}")
     */
    public function getProjectStatusByLabelAction($label)
    {

        $project_status = $this->getDoctrine()->getRepository('UABundle:ProjectStatus')->findOneBy(['label' => $label]);
        return array('project_status' => $project_status);
    }

    /**
     * Create a new ProjectStatus
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Create a new ProjectStatus",
     *  input="UABundle\Form\ProjectStatusType",
     *  output="UABundle\Entity\ProjectStatus",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/project_status")
     */
    public function postProjectStatusAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $project_status = new ProjectStatus();
        $form = $this->createForm(new ProjectStatusType(), $project_status);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_status);
            $em->flush();

            return array("project_status" => $project_status);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectStatus
     * Put action
     * @var Request $request
     * @var ProjectStatus $project_status
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Edit a ProjectStatus",
     *  input="UABundle\Form\ProjectStatusType",
     *  output="UABundle\Entity\ProjectStatus",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project_status", class="UABundle:ProjectStatus")
     * @Post("/project_status/{id}", requirements={"id" = "\d+"})
     */
    public function putProjectStatusAction(Request $request, ProjectStatus $project_status)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new ProjectStatusType(), $project_status);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_status);
            $em->flush();

            return array("project_status" => $project_status);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectStatus
     * Delete action
     * @var ProjectStatus $project_status
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectStatus",
     *  description="Delete a ProjectStatus",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project_status", class="UABundle:ProjectStatus")
     * @Delete("/project_status/{id}", requirements={"id" = "\d+"})
     */
    public function deleteProjectStatusAction(ProjectStatus $project_status)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($project_status);
        $em->flush();

        return array("status" => "Deleted");
    }

}
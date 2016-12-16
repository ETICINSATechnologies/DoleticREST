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
use UABundle\Entity\ProjectOrigin;
use UABundle\Form\ProjectOriginType;

class ProjectOriginController extends FOSRestController
{

    /**
     * Get all the project_origins
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Get all project_origins",
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
     * @Get("/project_origins")
     */
    public function getProjectOriginsAction()
    {

        $project_origins = $this->getDoctrine()->getRepository("UABundle:ProjectOrigin")
            ->findAll();

        return array('project_origins' => $project_origins);
    }

    /**
     * Get a project_origin by ID
     * @param ProjectOrigin $project_origin
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Get a project_origin",
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
     * @ParamConverter("project_origin", class="UABundle:ProjectOrigin")
     * @Get("/project_origin/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectOriginAction(ProjectOrigin $project_origin)
    {

        return array('project_origin' => $project_origin);

    }

    /**
     * Get a project_origin by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Get a project_origin",
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
     * @Get("/project_origin/{label}")
     */
    public function getProjectOriginByLabelAction($label)
    {

        $project_origin = $this->getDoctrine()->getRepository('UABundle:ProjectOrigin')->findOneBy(['label' => $label]);
        return array('project_origin' => $project_origin);
    }

    /**
     * Create a new ProjectOrigin
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Create a new ProjectOrigin",
     *  input="UABundle\Form\ProjectOriginType",
     *  output="UABundle\Entity\ProjectOrigin",
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
     * @Post("/project_origin")
     */
    public function postProjectOriginAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $project_origin = new ProjectOrigin();
        $form = $this->createForm(new ProjectOriginType(), $project_origin);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_origin);
            $em->flush();

            return array("project_origin" => $project_origin);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectOrigin
     * Put action
     * @var Request $request
     * @var ProjectOrigin $project_origin
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Edit a ProjectOrigin",
     *  input="UABundle\Form\ProjectOriginType",
     *  output="UABundle\Entity\ProjectOrigin",
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
     * @ParamConverter("project_origin", class="UABundle:ProjectOrigin")
     * @Post("/project_origin/{id}", requirements={"id" = "\d+"})
     */
    public function putProjectOriginAction(Request $request, ProjectOrigin $project_origin)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new ProjectOriginType(), $project_origin);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_origin);
            $em->flush();

            return array("project_origin" => $project_origin);
        }
        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectOrigin
     * Delete action
     * @var ProjectOrigin $project_origin
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectOrigin",
     *  description="Delete a ProjectOrigin",
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
     * @ParamConverter("project_origin", class="UABundle:ProjectOrigin")
     * @Delete("/project_origin/{id}")
     */
    public function deleteProjectOriginAction(ProjectOrigin $project_origin)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($project_origin);
        $em->flush();

        return array("status" => "Deleted");
    }

}
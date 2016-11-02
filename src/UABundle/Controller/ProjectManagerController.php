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
use UABundle\Entity\Project;
use UABundle\Entity\ProjectManager;
use UABundle\Form\ProjectManagerType;

class ProjectManagerController extends FOSRestController
{

    /**
     * Get all the project_managers
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectManager",
     *  description="Get all project_managers",
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
     * @Get("/project_managers")
     */
    public function getProjectManagersAction()
    {

        $project_managers = $this->getDoctrine()->getRepository("UABundle:ProjectManager")
            ->findAll();

        return array('project_managers' => $project_managers);
    }

    /**
     * Get all the project_managers
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectManager",
     *  description="Get all project_managers",
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
     * @Get("/project_managers/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectManagersByProjectAction(Project $project)
    {

        $project_managers = $this->getDoctrine()->getRepository("UABundle:ProjectManager")
            ->findBy(['project' => $project]);

        return array('project_managers' => $project_managers);
    }

    /**
     * Get a project_manager by ID
     * @param ProjectManager $project_manager
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectManager",
     *  description="Get a project_manager",
     *  requirements={
     *      {
     *          "name"="project_manager",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_manager id"
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
     * @ParamConverter("project_manager", class="UABundle:ProjectManager")
     * @Get("/project_manager/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectManagerAction(ProjectManager $project_manager)
    {

        return array('project_manager' => $project_manager);

    }

    /**
     * Create a new ProjectManager
     * @var Request $request
     * @param Project $project
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectManager",
     *  description="Create a new ProjectManager",
     *  input="UABundle\Form\ProjectManagerType",
     *  output="UABundle\Entity\ProjectManager",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project_manager/{id}", requirements={"id" = "\d+"}))
     */
    public function postProjectManagerAction(Request $request, Project $project)
    {
        $project_manager = new ProjectManager();
        $project_manager->setProject($project);
        $form = $this->createForm(new ProjectManagerType(), $project_manager);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_manager);
            $em->flush();

            return array("project_manager" => $project_manager);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectManager
     * Delete action
     * @var ProjectManager $project_manager
     * @return array
     *
     * @View()
     * @ParamConverter("project_manager", class="UABundle:ProjectManager")
     * @Delete("/project_manager/{id}")
     */
    public function deleteProjectManagerAction(ProjectManager $project_manager)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_manager);
        $em->flush();

        return array("status" => "Deleted");
    }

}
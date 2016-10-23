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
use UABundle\Form\ProjectType;

class ProjectController extends FOSRestController
{

    /**
     * Get all the projects
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects",
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
     * @Get("/projects")
     */
    public function getProjectsAction(){

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findAll();

        return array('projects' => $projects);
    }

    /**
     * Get a project by ID
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get a project",
     *  requirements={
     *      {
     *          "name"="project",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project id"
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/project/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectAction(Project $project){

        return array('project' => $project);

    }

    /**
     * Get a project by number
     * @param string $number
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get a project",
     *  requirements={
     *      {
     *          "name"="number",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project number"
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
     * @Get("/project/number/{number}")
     */
    public function getProjectByNumberAction($number){

        $project = $this->getDoctrine()->getRepository('UABundle:Project')->findOneBy(['number' => $number]);
        return array('project' => $project);
    }

    /**
     * Create a new Project
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Create a new Project",
     *  input="UABundle\Form\ProjectType",
     *  output="UABundle\Entity\Project",
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
     * @Post("/project")
     */
    public function postProjectAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(new ProjectType(), $project);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            return array("project" => $project);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Edit a Project",
     *  requirements={
     *      {
     *          "name"="project",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project id"
     *      }
     *  },
     *  input="UABundle\Form\ProjectType",
     *  output="UABundle\Entity\Project",
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
     * @Put("/project/{id}")
     */
    public function putProjectAction(Request $request, Project $project)
    {
        $form = $this->createForm(new ProjectType(), $project);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            return array("project" => $project);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Project
     * Delete action
     * @var Project $project
     * @return array
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Delete("/project/{id}")
     */
    public function deleteProjectAction(Project $project)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return array("status" => "Deleted");
    }

}
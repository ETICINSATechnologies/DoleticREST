<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\ProjectFile;
use UABundle\Entity\Project;
use UABundle\Form\ProjectFileType;

class ProjectFileController extends FOSRestController
{

    /**
     * Get all the project_files
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Get all project_files",
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
     * @Get("/project_files")
     */
    public function getProjectFilesAction()
    {

        $project_files = $this->getDoctrine()->getRepository("UABundle:ProjectFile")
            ->findAll();

        $array = [];
        foreach ($project_files as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the project_files in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Get all project_files in a project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/project_files/project/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectFilesByProjectAction(Project $project)
    {

        $project_files = $this->getDoctrine()->getRepository("UABundle:ProjectFile")
            ->findBy(['project' => $project]);

        $array = [];
        foreach ($project_files as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the project_files validated by a user
     * @param User $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Get all project_files validated by a user",
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
     * @Get("/project_files/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectFilesByAuditorAction(User $auditor)
    {

        $project_files = $this->getDoctrine()->getRepository("UABundle:ProjectFile")
            ->findBy(['auditor' => $auditor]);

        $array = [];
        foreach ($project_files as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the project_files validated by the current user
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Get all project_files validated by the current user",
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
     * @Get("/project_files/auditor/current")
     */
    public function getCurrentUserAuditedProjectFilesAction()
    {

        $project_files = $this->getDoctrine()->getRepository("UABundle:ProjectFile")
            ->findBy(['auditor' => $this->getUser()]);

        $array = [];
        foreach ($project_files as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a project_file by ID
     * @param ProjectFile $project_file
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Get a project_file",
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
     * @ParamConverter("project_file", class="UABundle:ProjectFile")
     * @Get("/project_file/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectFileAction(ProjectFile $project_file)
    {

        return $project_file;

    }

    /**
     * Create a new ProjectFile
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Create a new ProjectFile",
     *  input="UABundle\Form\ProjectFileType",
     *  output="UABundle\Entity\ProjectFile",
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
     * @Post("/project_file")
     */
    public function postProjectFileAction(Request $request)
    {
        $project_file = new ProjectFile();
        $form = $this->createForm(new ProjectFileType(), $project_file);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_file);
            $em->flush();

            return $project_file;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ProjectFile
     * Put action
     * @var Request $request
     * @var ProjectFile $project_file
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Edit a ProjectFile",
     *  input="UABundle\Form\ProjectFileType",
     *  output="UABundle\Entity\ProjectFile",
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
     * @ParamConverter("project_file", class="UABundle:ProjectFile")
     * @Post("/project_file/{id}", requirements={"id" = "\d+"})
     */
    public function putProjectFileAction(Request $request, ProjectFile $project_file)
    {
        $form = $this->createForm(new ProjectFileType(), $project_file);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project_file);
            $em->flush();

            return $project_file;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectFile
     * Delete action
     * @var ProjectFile $project_file
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectFile",
     *  description="Delete a ProjectFile",
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
     * @ParamConverter("project_file", class="UABundle:ProjectFile")
     * @Delete("/project_file/{id}", requirements={"id" = "\d+"})
     */
    public function deleteProjectFileAction(ProjectFile $project_file)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_file);
        $em->flush();

        return array("status" => "Deleted");
    }

}
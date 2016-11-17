<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use GRCBundle\Entity\Contact;
use GRCBundle\Entity\Firm;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RHBundle\Entity\UserData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Project;
use UABundle\Entity\ProjectField;
use UABundle\Entity\ProjectOrigin;
use UABundle\Entity\ProjectStatus;
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
    public function getProjectsAction()
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy([], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects from a given origin
     * @param ProjectOrigin $origin
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects from a given origin",
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
     * @ParamConverter("origin", class="UABundle:ProjectOrigin")
     * @Get("/projects/origin/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByOriginAction(ProjectOrigin $origin)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['origin' => $origin], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects in a field
     * @param ProjectField $field
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects in a field",
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
     * @ParamConverter("field", class="UABundle:ProjectField")
     * @Get("/projects/field/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByFieldAction(ProjectField $field)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['field' => $field], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects at a status
     * @param ProjectStatus $status
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects at a status",
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
     * @ParamConverter("status", class="UABundle:ProjectOrigin")
     * @Get("/projects/status/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByStatusAction(ProjectStatus $status)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['status' => $status], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects with a firm
     * @param Firm $firm
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects with a firm",
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Get("/projects/status/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByFirmAction(Firm $firm)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['firm' => $firm], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects audited by a user
     * @param UserData $auditor
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects audited by a user",
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
     * @Get("/projects/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByAuditorAction(UserData $auditor)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['auditor' => $auditor], ['number' => 'DESC']);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects led by a Manager
     * @param UserData $manager
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects led by a Manager",
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
     * @ParamConverter("manager", class="KernelBundle:User")
     * @Get("/projects/manager/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByManagerAction(UserData $manager)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByManager($manager);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects worked by a consultant
     * @param User $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects worked by a consultant",
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
     * @ParamConverter("consultant", class="KernelBundle:User")
     * @Get("/projects/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByConsultant(User $consultant)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByConsultant($consultant);

        return array('projects' => $projects);
    }

    /**
     * Get all the projects worked associated to a contact
     * @param Contact $contact
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all projects associated to a contact",
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
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Get("/projects/contact/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByContact(Contact $contact)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByContact($contact);

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
    public function getProjectAction(Project $project)
    {

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
    public function getProjectByNumberAction($number)
    {

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
        $this->denyAccessUnlessGranted('ROLE_UA_ADMIN');

        $project = new Project();
        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::ADD_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $project
                ->setDisabled(false)
                ->setArchived(false)
                ->setManagementFee(0)
                ->setApplicationFee(0)
                ->setAdvance(0)
                ->setRebilledFee(0);
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
     * @Post("/project/{id}")
     */
    public function putProjectAction(Request $request, Project $project)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::EDIT_MODE]);
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
     * Sign a project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Sign a Project",
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
     * @Post("/project/{id}/sign")
     */
    public function signProjectAction(Request $request, Project $project)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::SIGN_MODE]);
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
     * End a project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="End a Project",
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
     * @Post("/project/{id}/end")
     */
    public function endProjectAction(Request $request, Project $project)
    {
        if ($this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
            throw new AccessDeniedException();
        }

        if ($project->getSignDate() === null) {
            return array("error" => "Impossible de terminer le projet.");
        }

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::END_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($project->getSignDate() >= $project->getEndDate()) {
                return array("error" => "Date invalide");
            }
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
     * Disable a project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Disable a Project",
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
     * @Post("/project/{id}/disable")
     */
    public function disableProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::DISABLE_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $project->setDisabled(true)->setDisabledSince(new \DateTime());
            if ($project->getDisabledSince() > $project->getDisabledUntil()) {
                return ["error" => "Date invalide."];
            }
            $em->persist($project);
            $em->flush();

            return array("project" => $project);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Enable a project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Enable a Project",
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
     * @Post("/project/{id}/enable")
     */
    public function enableProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project
            ->setDisabled(false)
            ->setDisabledSince(null)
            ->setDisabledUntil(null);
        $em->persist($project);
        $em->flush();

        return array("project" => $project);
    }

    /**
     * Cancel a project signature
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Cancel a Project signature",
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
     * @Post("/project/{id}/unsign")
     */
    public function unsignProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        if ($project->getEndDate() !== null) {
            return array("error" => "Impossible d'annuler la signature");
        }

        $em = $this->getDoctrine()->getManager();

        $project->setSignDate(null);
        $em->persist($project);
        $em->flush();

        return array("project" => $project);
    }

    /**
     * Cancel a project end
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Cancel a Project end",
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
     * @Post("/project/{id}/unend")
     */
    public function unendProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setEndDate(null);
        $em->persist($project);
        $em->flush();

        return array("project" => $project);
    }

    /**
     * Archive a Project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Archive a Project",
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
     * @Post("/project/{id}/archive")
     */
    public function archiveProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setArchived(true)->setArchivedSince(new \DateTime());
        $em->persist($project);
        $em->flush();

        return array("project" => $project);
    }

    /**
     * Remove a Project from archives
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Remove a Project from archives",
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
     * @Post("/project/{id}/unarchive")
     */
    public function unarchiveProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setArchived(false)->setArchivedSince(null);
        $em->persist($project);
        $em->flush();

        return array("project" => $project);
    }

    /**
     * Assign an auditor to a Project
     * Put action
     * @var Request $request
     * @var Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Assign an auditor to a Project",
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
     * @Post("/project/{id}/auditor")
     */
    public function auditorProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::AUDITOR_MODE]);
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
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return array("status" => "Deleted");
    }

}
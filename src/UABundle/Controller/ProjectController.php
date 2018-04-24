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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Project;
use UABundle\Entity\ProjectField;
use UABundle\Entity\ProjectManager;
use UABundle\Entity\ProjectOrigin;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/projects")
     */
    public function getProjectsAction()
    {

        return $this->getDoctrine()->getRepository("UABundle:Project")->getAllProjects();
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
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

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the projects audited by a user
     * @param User $auditor
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("auditor", class="KernelBundle:User")
     * @Get("/projects/auditor/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByAuditorAction(User $auditor)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['auditor' => $auditor], ['number' => 'DESC']);

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the projects led by a Manager
     * @param User $manager
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("manager", class="KernelBundle:User")
     * @Get("/projects/manager/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByManagerAction(User $manager)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByManager($manager);

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant", class="KernelBundle:User")
     * @Get("/projects/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByConsultantAction(User $consultant)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByConsultant($consultant);

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
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
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Get("/projects/contact/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectsByContactAction(Contact $contact)
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findByContact($contact);

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all active projects that are yet to be signed
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all active projects that are yet to be signed",
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
     * @Get("/projects/unsigned")
     */
    public function getUnsignedProjectsAction()
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findUnsigned();

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all active projects that are currently being implemented
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all active projects that are currently being implemented",
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
     * @Get("/projects/current")
     */
    public function getCurrentProjectsAction()
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findCurrent();

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all disabled projects
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all disabled projects",
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
     * @Get("/projects/disabled")
     */
    public function getDisabledProjectsAction()
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findBy(['disabled' => true]);

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all archived and enabled projects
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get all archived and enabled projects",
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
     * @Get("/projects/archived")
     */
    public function getArchivedProjectsAction()
    {

        $projects = $this->getDoctrine()->getRepository("UABundle:Project")
            ->findArchived();

        $array = [];
        foreach ($projects as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a project by ID
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get a project",
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
     * @Get("/project/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectAction(Project $project)
    {

        return $project;

    }

    /**
     * Get a project by number
     * @param string $number
     * @return array
     *
     * @ApiDoc(
     *  section="Project",
     *  description="Get a project",
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
     * @Get("/project/number/{number}", requirements={"number" = "\d+"})
     */
    public function getProjectByNumberAction($number)
    {

        $project = $this->getDoctrine()->getRepository('UABundle:Project')->findOneBy(['number' => $number]);
        return $project;
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
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
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
            $currentAsManager = $form['currentAsManager']->getData();

            $em = $this->getDoctrine()->getManager();
            $project
                ->setDisabled(false)
                ->setArchived(false)
                ->setManagementFee(0)
                ->setApplicationFee(0)
                ->setAdvance(0)
                ->setRebilledFee(0);
            $em->persist($project);

            if ($currentAsManager) {
                $manager = new ProjectManager();
                $manager
                    ->setManager($this->getUser())
                    ->setProject($project);
                $em->persist($manager);
                $project->setManagers([$manager]);
            }
            $em->flush();

            return $project;

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
     *  input="UABundle\Form\ProjectType",
     *  output="UABundle\Entity\Project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}", requirements={"id" = "\d+"})
     */
    public function putProjectAction(Request $request, Project $project)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::EDIT_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            return $project;
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
     *  input="UABundle\Form\ProjectType",
     *  output="UABundle\Entity\Project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/sign", requirements={"id" = "\d+"})
     */
    public function signProjectAction(Request $request, Project $project)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::SIGN_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($project);
            $em->flush();

            return $project;
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
     *  input="UABundle\Form\ProjectType",
     *  output="UABundle\Entity\Project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/end", requirements={"id" = "\d+"})
     */
    public function endProjectAction(Request $request, Project $project)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $project)) {
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

            return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/disable", requirements={"id" = "\d+"})
     */
    public function disableProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new ProjectType(), $project, ['mode' => ProjectType::DISABLE_MODE]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $project->setDisabled(true)->setDisabledSince(new \DateTime());
            $until = $project->getDisabledUntil();
            if (isset($until) && $project->getDisabledSince() > $until) {
                return ["error" => "Date invalide."];
            }
            $em->persist($project);
            $em->flush();

            return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/enable", requirements={"id" = "\d+"})
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

        return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/unsign", requirements={"id" = "\d+"})
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

        return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/unend", requirements={"id" = "\d+"})
     */
    public function unendProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setEndDate(null);
        $em->persist($project);
        $em->flush();

        return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/archive", requirements={"id" = "\d+"})
     */
    public function archiveProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setArchived(true)->setArchivedSince(new \DateTime());
        $em->persist($project);
        $em->flush();

        return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/unarchive", requirements={"id" = "\d+"})
     */
    public function unarchiveProjectAction(Request $request, Project $project)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();

        $project->setArchived(false)->setArchivedSince(null);
        $em->persist($project);
        $em->flush();

        return $project;
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
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project/{id}/auditor", requirements={"id" = "\d+"})
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

            return $project;
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
     * @ApiDoc(
     *  section="Project",
     *  description="Delete a project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Delete("/project/{id}", requirements={"id" = "\d+"})
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
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
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Consultant;
use UABundle\Entity\Project;
use UABundle\Form\ConsultantType;

class ConsultantController extends FOSRestController
{

    /**
     * Get all the consultants
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants",
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
     * @Get("/consultants")
     */
    public function getConsultantsAction()
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy([], ['number' => 'ASC']);

        $array = [];
        foreach ($consultants as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the consultants in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants in a project",
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
     * @Get("/consultants/project/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantsByProjectAction(Project $project)
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy(['project' => $project]);

        $array = [];
        foreach ($consultants as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the consultants linked to a user data
     * @param User $user
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants linked to a user data",
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
     * @ParamConverter("user", class="KernelBundle:User")
     * @Get("/consultants/user/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantsByUserAction(User $user)
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy(['user' => $user]);

        $array = [];
        foreach ($consultants as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a consultant by ID
     * @param Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get a consultant",
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Get("/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantAction(Consultant $consultant)
    {

        return $consultant;

    }

    /**
     * Create a new Consultant
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Create a new Consultant",
     *  input="UABundle\Form\ConsultantType",
     *  output="UABundle\Entity\Consultant",
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
     * @Post("/consultant")
     */
    public function postConsultantAction(Request $request)
    {
        $consultant = new Consultant();
        $form = $this->createForm(new ConsultantType(), $consultant);
        $form->handleRequest($request);

        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $consultant->getProject())) {
            throw new AccessDeniedException();
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant);
            $em->flush();

            return $consultant;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Consultant
     * Put action
     * @var Request $request
     * @var Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Edit a Consultant",
     *  input="UABundle\Form\ConsultantType",
     *  output="UABundle\Entity\Consultant",
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Post("/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function putConsultantAction(Request $request, Consultant $consultant)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $consultant->getProject())) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ConsultantType(), $consultant);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant);
            $em->flush();

            return $consultant;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Consultant
     * Delete action
     * @var Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Delete a Consultant",
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Delete("/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function deleteConsultantAction(Consultant $consultant)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $consultant->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant);
        $em->flush();

        return array("status" => "Deleted");
    }

}
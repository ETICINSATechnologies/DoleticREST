<?php

namespace RHBundle\Controller;


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
use RHBundle\Entity\ConsultantMembership;
use RHBundle\Form\ConsultantMembershipType;

class ConsultantMembershipController extends FOSRestController
{

    /**
     * Get all the consultant_memberships
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Get all consultant_memberships",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Get("/consultant_memberships")
     */
    public function getConsultantMembershipsAction()
    {

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $consultant_memberships = $this->getDoctrine()->getRepository("RHBundle:ConsultantMembership")
            ->findAll();

        $array = [];
        foreach ($consultant_memberships as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the consultant memberships for a given user data
     * @param User $user
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Get all the consultant memberships for a given user data",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("user", class="KernelBundle:User")
     * @Get("/consultant_memberships/user/{id}", requirements={"id" = "\d+"})
     */
    public function getAdministratorMembershipsByUserAction(User $user)
    {

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $consultant_memberships = $this->getDoctrine()->getRepository("RHBundle:ConsultantMembership")
            ->findBy(['user' => $user]);

        $array = [];
        foreach ($consultant_memberships as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a consultant_membership by ID
     * @param ConsultantMembership $consultant_membership
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Get a consultant_membership",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Get("/consultant_membership/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantMembershipAction(ConsultantMembership $consultant_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        return $consultant_membership;

    }

    /**
     * Create a new ConsultantMembership
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Create a new ConsultantMembership",
     *  input="RHBundle\Form\ConsultantMembershipType",
     *  output="RHBundle\Entity\ConsultantMembership",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/consultant_membership")
     */
    public function postConsultantMembershipAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $consultant_membership = new ConsultantMembership();
        $form = $this->createForm(new ConsultantMembershipType(), $consultant_membership);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant_membership);
            $em->flush();

            return $consultant_membership;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ConsultantMembership
     * Put action
     * @var Request $request
     * @var ConsultantMembership $consultant_membership
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Edit a ConsultantMembership",
     *  input="RHBundle\Form\ConsultantMembershipType",
     *  output="RHBundle\Entity\ConsultantMembership",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Post("/consultant_membership/{id}", requirements={"id" = "\d+"})
     */
    public function putConsultantMembershipAction(Request $request, ConsultantMembership $consultant_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new ConsultantMembershipType(), $consultant_membership);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant_membership);
            $em->flush();

            return $consultant_membership;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ConsultantMembership
     * Delete action
     * @var ConsultantMembership $consultant_membership
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Delete a ConsultantMembership",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Delete("/consultant_membership/{id}", requirements={"id" = "\d+"})
     */
    public function deleteConsultantMembershipAction(ConsultantMembership $consultant_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant_membership);
        $em->flush();

        return array("status" => "Deleted");
    }

}
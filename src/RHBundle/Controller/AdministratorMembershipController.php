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
use RHBundle\Entity\AdministratorMembership;
use RHBundle\Form\AdministratorMembershipType;

class AdministratorMembershipController extends FOSRestController
{

    /**
     * Get all the administrator_memberships
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Get all administrator_memberships",
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
     * @Get("/administrator_memberships")
     */
    public function getAdministratorMembershipsAction(){

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $administrator_memberships = $this->getDoctrine()->getRepository("RHBundle:AdministratorMembership")
            ->findAll();

        $array = [];
        foreach ($administrator_memberships as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the administrator_memberships for a given user data
     * @param User $user
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Get all administrator memberships for a given user data",
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
     * @Get("/administrator_memberships/user/{id}", requirements={"id" = "\d+"})
     */
    public function getAdministratorMembershipsByUserAction(User $user){

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $administrator_memberships = $this->getDoctrine()->getRepository("RHBundle:AdministratorMembership")
            ->findBy(['user' => $user]);

        $array = [];
        foreach ($administrator_memberships as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a administrator_membership by ID
     * @param AdministratorMembership $administrator_membership
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Get a administrator_membership",
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
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Get("/administrator_membership/{id}", requirements={"id" = "\d+"})
     */
    public function getAdministratorMembershipAction(AdministratorMembership $administrator_membership){

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        return $administrator_membership;

    }

    /**
     * Create a new AdministratorMembership
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Create a new AdministratorMembership",
     *  input="RHBundle\Form\AdministratorMembershipType",
     *  output="RHBundle\Entity\AdministratorMembership",
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
     * @Post("/administrator_membership")
     */
    public function postAdministratorMembershipAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $administrator_membership = new AdministratorMembership();
        $form = $this->createForm(new AdministratorMembershipType(), $administrator_membership);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($administrator_membership);
            $em->flush();

            return $administrator_membership;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a AdministratorMembership
     * Put action
     * @var Request $request
     * @var AdministratorMembership $administrator_membership
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Edit a AdministratorMembership",
     *  input="RHBundle\Form\AdministratorMembershipType",
     *  output="RHBundle\Entity\AdministratorMembership",
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
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Post("/administrator_membership/{id}", requirements={"id" = "\d+"})
     */
    public function putAdministratorMembershipAction(Request $request, AdministratorMembership $administrator_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new AdministratorMembershipType(), $administrator_membership);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($administrator_membership);
            $em->flush();

            return $administrator_membership;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a AdministratorMembership
     * Delete action
     * @var AdministratorMembership $administrator_membership
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Delete a AdministratorMembership",
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
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Delete("/administrator_membership/{id}", requirements={"id" = "\d+"})
     */
    public function deleteAdministratorMembershipAction(AdministratorMembership $administrator_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($administrator_membership);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RHBundle\Entity\UserData;
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
     *   "need validations" = "#ff0000"
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

        return array('administrator_memberships' => $administrator_memberships);
    }

    /**
     * Get all the administrator_memberships for a given user data
     * @param UserData $userData
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Get all administrator memberships for a given user data",
     *  requirements={
     *      {
     *          "name"="user_data",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="user data id"
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
     * @ParamConverter("userData", class="RHBundle:UserData")
     * @Get("/administrator_memberships/user_data/{id}", requirements={"id" = "\d+"})
     */
    public function getAdministratorMembershipsByUserDataAction(UserData $userData){

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        $administrator_memberships = $this->getDoctrine()->getRepository("RHBundle:AdministratorMembership")
            ->findBy(['userData' => $userData]);

        return array('administrator_memberships' => $administrator_memberships);
    }

    /**
     * Get a administrator_membership by ID
     * @param AdministratorMembership $administrator_membership
     * @return array
     *
     * @ApiDoc(
     *  section="AdministratorMembership",
     *  description="Get a administrator_membership",
     *  requirements={
     *      {
     *          "name"="administrator_membership",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="administrator_membership id"
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
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Get("/administrator_membership/{id}", requirements={"id" = "\d+"})
     */
    public function getAdministratorMembershipAction(AdministratorMembership $administrator_membership){

        $this->denyAccessUnlessGranted('ROLE_RH_ADMIN');

        return array('administrator_membership' => $administrator_membership);

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
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
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

            return array("administrator_membership" => $administrator_membership);

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
     *  requirements={
     *      {
     *          "name"="administrator_membership",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="administrator_membership id"
     *      }
     *  },
     *  input="RHBundle\Form\AdministratorMembershipType",
     *  output="RHBundle\Entity\AdministratorMembership",
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
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Put("/administrator_membership/{id}")
     */
    public function putAdministratorMembershipAction(Request $request, AdministratorMembership $administrator_membership)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new AdministratorMembershipType(), $administrator_membership);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($administrator_membership);
            $em->flush();

            return array("administrator_membership" => $administrator_membership);
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
     * @View()
     * @ParamConverter("administrator_membership", class="RHBundle:AdministratorMembership")
     * @Delete("/administrator_membership/{id}")
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
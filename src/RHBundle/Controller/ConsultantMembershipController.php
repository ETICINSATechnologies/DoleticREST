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
     *   "need validations" = "#ff0000"
     *  }
     * )
     *
     * @View()
     * @Get("/consultant_memberships")
     */
    public function getConsultantMembershipsAction(){

        $consultant_memberships = $this->getDoctrine()->getRepository("RHBundle:ConsultantMembership")
            ->findAll();

        return array('consultant_memberships' => $consultant_memberships);
    }

    /**
     * Get all the consultant memberships for a given user data
     * @param UserData $userData
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Get all the consultant memberships for a given user data",
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

        $consultant_memberships = $this->getDoctrine()->getRepository("RHBundle:ConsultantMembership")
            ->findBy(['userData' => $userData]);

        return array('consultant_memberships' => $consultant_memberships);
    }

    /**
     * Get a consultant_membership by ID
     * @param ConsultantMembership $consultant_membership
     * @return array
     *
     * @ApiDoc(
     *  section="ConsultantMembership",
     *  description="Get a consultant_membership",
     *  requirements={
     *      {
     *          "name"="consultant_membership",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="consultant_membership id"
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
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Get("/consultant_membership/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantMembershipAction(ConsultantMembership $consultant_membership){

        return array('consultant_membership' => $consultant_membership);

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
     *   "need validations" = "#ff0000"
     *  },
     *  views = { "premium" }
     * )
     *
     * @View()
     * @Post("/consultant_membership")
     */
    public function postConsultantMembershipAction(Request $request)
    {
        $consultant_membership = new ConsultantMembership();
        $form = $this->createForm(new ConsultantMembershipType(), $consultant_membership);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant_membership);
            $em->flush();

            return array("consultant_membership" => $consultant_membership);

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
     *  requirements={
     *      {
     *          "name"="consultant_membership",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="consultant_membership id"
     *      }
     *  },
     *  input="RHBundle\Form\ConsultantMembershipType",
     *  output="RHBundle\Entity\ConsultantMembership",
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
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Put("/consultant_membership/{id}")
     */
    public function putConsultantMembershipAction(Request $request, ConsultantMembership $consultant_membership)
    {
        $form = $this->createForm(new ConsultantMembershipType(), $consultant_membership);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant_membership);
            $em->flush();

            return array("consultant_membership" => $consultant_membership);
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
     * @View()
     * @ParamConverter("consultant_membership", class="RHBundle:ConsultantMembership")
     * @Delete("/consultant_membership/{id}")
     */
    public function deleteConsultantMembershipAction(ConsultantMembership $consultant_membership)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant_membership);
        $em->flush();

        return array("status" => "Deleted");
    }

}
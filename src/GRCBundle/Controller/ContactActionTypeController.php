<?php

namespace GRCBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use GRCBundle\Entity\ContactActionType;
use GRCBundle\Form\ContactActionTypeType;

class ContactActionTypeController extends FOSRestController
{

    /**
     * Get all the contact_action_types
     * @return array
     *
     * @ApiDoc(
     *  section="ContactActionType",
     *  description="Get all contact_action_types",
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
     * @Get("/contact_action_types")
     */
    public function getContactActionTypesAction()
    {

        $contact_action_types = $this->getDoctrine()->getRepository("GRCBundle:ContactActionType")
            ->findAll();

        return array('contact_action_types' => $contact_action_types);
    }

    /**
     * Get a contact_action_type by ID
     * @param ContactActionType $contact_action_type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactActionType",
     *  description="Get a contact_action_type",
     *  requirements={
     *      {
     *          "name"="contact_action_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact_action_type id"
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
     * @ParamConverter("contact_action_type", class="GRCBundle:ContactActionType")
     * @Get("/contact_action_type/{id}", requirements={"id" = "\d+"})
     */
    public function getContactActionTypeAction(ContactActionType $contact_action_type)
    {

        return array('contact_action_type' => $contact_action_type);

    }

    /**
     * Get a contact_action_type by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="ContactActionType",
     *  description="Get a contact_action_type",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact_action_type label"
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
     * @Get("/contact_action_type/{label}")
     */
    public function getContactActionTypeByLabelAction($label)
    {

        $contact_action_type = $this->getDoctrine()->getRepository('GRCBundle:ContactActionType')->findOneBy(['label' => $label]);
        return array('contact_action_type' => $contact_action_type);
    }

    /**
     * Create a new ContactActionType
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ContactActionType",
     *  description="Create a new ContactActionType",
     *  input="GRCBundle\Form\ContactActionTypeType",
     *  output="GRCBundle\Entity\ContactActionType",
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
     * @Post("/contact_action_type")
     */
    public function postContactActionTypeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $contact_action_type = new ContactActionType();
        $form = $this->createForm(new ContactActionTypeType(), $contact_action_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact_action_type);
            $em->flush();

            return array("contact_action_type" => $contact_action_type);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ContactActionType
     * Put action
     * @var Request $request
     * @var ContactActionType $contact_action_type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactActionType",
     *  description="Edit a ContactActionType",
     *  requirements={
     *      {
     *          "name"="contact_action_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact_action_type id"
     *      }
     *  },
     *  input="GRCBundle\Form\ContactActionTypeType",
     *  output="GRCBundle\Entity\ContactActionType",
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
     * @ParamConverter("contact_action_type", class="GRCBundle:ContactActionType")
     * @Post("/contact_action_type/{id}")
     */
    public function putContactActionTypeAction(Request $request, ContactActionType $contact_action_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $form = $this->createForm(new ContactActionTypeType(), $contact_action_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact_action_type);
            $em->flush();

            return array("contact_action_type" => $contact_action_type);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ContactActionType
     * Delete action
     * @var ContactActionType $contact_action_type
     * @return array
     *
     * @View()
     * @ParamConverter("contact_action_type", class="GRCBundle:ContactActionType")
     * @Delete("/contact_action_type/{id}")
     */
    public function deleteContactActionTypeAction(ContactActionType $contact_action_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact_action_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
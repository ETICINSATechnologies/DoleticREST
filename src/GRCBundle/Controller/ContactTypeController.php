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
use GRCBundle\Entity\ContactType;
use GRCBundle\Form\ContactTypeType;

class ContactTypeController extends FOSRestController
{

    /**
     * Get all the contact_types
     * @return array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Get all contact_types",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/contact_types")
     */
    public function getContactTypesAction()
    {

        $contact_types = $this->getDoctrine()->getRepository("GRCBundle:ContactType")
            ->findAll();

        return array('contact_types' => $contact_types);
    }

    /**
     * Get a contact_type by ID
     * @param ContactType $contact_type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Get a contact_type",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact_type", class="GRCBundle:ContactType")
     * @Get("/contact_type/{id}", requirements={"id" = "\d+"})
     */
    public function getContactTypeAction(ContactType $contact_type)
    {

        return array('contact_type' => $contact_type);

    }

    /**
     * Get a contact_type by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Get a contact_type",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/contact_type/{label}")
     */
    public function getContactTypeByLabelAction($label)
    {

        $contact_type = $this->getDoctrine()->getRepository('GRCBundle:ContactType')->findOneBy(['label' => $label]);
        return array('contact_type' => $contact_type);
    }

    /**
     * Create a new ContactType
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Create a new ContactType",
     *  input="GRCBundle\Form\ContactTypeType",
     *  output="GRCBundle\Entity\ContactType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/contact_type")
     */
    public function postContactTypeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $contact_type = new ContactType();
        $form = $this->createForm(new ContactTypeType(), $contact_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact_type);
            $em->flush();

            return array("contact_type" => $contact_type);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ContactType
     * Put action
     * @var Request $request
     * @var ContactType $contact_type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Edit a ContactType",
     *  input="GRCBundle\Form\ContactTypeType",
     *  output="GRCBundle\Entity\ContactType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact_type", class="GRCBundle:ContactType")
     * @Post("/contact_type/{id}", requirements={"id" = "\d+"})
     */
    public function putContactTypeAction(Request $request, ContactType $contact_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $form = $this->createForm(new ContactTypeType(), $contact_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact_type);
            $em->flush();

            return array("contact_type" => $contact_type);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ContactType
     * Delete action
     * @var ContactType $contact_type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactType",
     *  description="Delete a ContactType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact_type", class="GRCBundle:ContactType")
     * @Delete("/contact_type/{id}")
     */
    public function deleteContactTypeAction(ContactType $contact_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
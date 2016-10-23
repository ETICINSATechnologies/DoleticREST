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
use GRCBundle\Entity\Contact;
use GRCBundle\Form\ContactType;

class ContactController extends FOSRestController
{

    /**
     * Get all the contacts
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get all contacts",
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
     * @Get("/contacts")
     */
    public function getContactsAction(){

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findAll();

        return array('contacts' => $contacts);
    }

    /**
     * Get a contact by ID
     * @param Contact $contact
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get a contact",
     *  requirements={
     *      {
     *          "name"="contact",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact id"
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
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Get("/contact/{id}", requirements={"id" = "\d+"})
     */
    public function getContactAction(Contact $contact){

        return array('contact' => $contact);

    }

    /**
     * Get a contact by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get a contact",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact label"
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
     * @Get("/contact/{label}")
     */
    public function getContactByLabelAction($label){

        $contact = $this->getDoctrine()->getRepository('GRCBundle:Contact')->findOneBy(['label' => $label]);
        return array('contact' => $contact);
    }

    /**
     * Create a new Contact
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Create a new Contact",
     *  input="GRCBundle\Form\ContactType",
     *  output="GRCBundle\Entity\Contact",
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
     * @Post("/contact")
     */
    public function postContactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return array("contact" => $contact);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Contact
     * Put action
     * @var Request $request
     * @var Contact $contact
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Edit a Contact",
     *  requirements={
     *      {
     *          "name"="contact",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact id"
     *      }
     *  },
     *  input="GRCBundle\Form\ContactType",
     *  output="GRCBundle\Entity\Contact",
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
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Put("/contact/{id}")
     */
    public function putContactAction(Request $request, Contact $contact)
    {
        $form = $this->createForm(new ContactType(), $contact);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact);
            $em->flush();

            return array("contact" => $contact);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Contact
     * Delete action
     * @var Contact $contact
     * @return array
     *
     * @View()
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Delete("/contact/{id}")
     */
    public function deleteContactAction(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return array("status" => "Deleted");
    }

}
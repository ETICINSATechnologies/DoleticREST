<?php

namespace GRCBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use GRCBundle\Entity\Firm;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use GRCBundle\Entity\Contact;
use GRCBundle\Entity\ContactType as Type;
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
    public function getContactsAction()
    {

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findAll();

        return array('contacts' => $contacts);
    }

    /**
     * Get all the contacts with specified type
     * @param Type $type
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get all the contacts with specified type",
     *  requirements={
     *      {
     *          "name"="type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact type id"
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
     * @ParamConverter("type", class="GRCBundle:ContactType")
     * @Get("/contacts/type/{id}", requirements={"id" = "\d+"})
     */
    public function getContactsByTypeAction(Type $type)
    {

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findBy(['type' => $type]);

        return array('contacts' => $contacts);
    }

    /**
     * Get all the contacts in specified firm
     * @param Firm $firm
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get all the contacts in specified firm",
     *  requirements={
     *      {
     *          "name"="type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="contact type id"
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Get("/contacts/firm/{id}", requirements={"id" = "\d+"})
     */
    public function getContactsByFirmAction(Firm $firm)
    {

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findBy(['firm' => $firm]);

        return array('contacts' => $contacts);
    }

    /**
     * Get all the contacts by a creator
     * @param User $creator
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get all contacts by a creator",
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
     * @ParamConverter("creator", class="KernelBundle:User")
     * @Get("/contacts/creator/{id}", requirements={"id" = "\d+"})
     */
    public function getContactsByAuthorAction(User $creator)
    {

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findBy(['creator' => $creator]);

        return array('contacts' => $contacts);
    }

    /**
     * Get all the contacts by current user
     * @return array
     *
     * @ApiDoc(
     *  section="Contact",
     *  description="Get all contacts by current user",
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
     * @Get("/contacts/current")
     */
    public function getCurrentUserContactsAction()
    {

        $contacts = $this->getDoctrine()->getRepository("GRCBundle:Contact")
            ->findBy(['creator' => $this->getUser()]);

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
    public function getContactAction(Contact $contact)
    {

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
        $this->denyAccessUnlessGranted('ROLE_GRC_ADMIN');

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
     * @Post("/contact/{id}")
     */
    public function putContactAction(Request $request, Contact $contact)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_ADMIN');

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
        if (
            $this->getUser()->getId() !== $contact->getCreator()->getId()
            && $this->isGranted('ROLE_GRC_SUPERADMIN') === false
        ) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return array("status" => "Deleted");
    }

}
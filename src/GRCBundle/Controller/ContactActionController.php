<?php

namespace GRCBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use GRCBundle\Entity\Contact;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use GRCBundle\Entity\ContactAction;
use GRCBundle\Entity\ContactActionType as Type;
use GRCBundle\Form\ContactActionType;

class ContactActionController extends FOSRestController
{

    /**
     * Get all the contact_actions
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get all contact_actions",
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
     * @Get("/contact_actions")
     */
    public function getContactActionsAction()
    {

        $contact_actions = $this->getDoctrine()->getRepository("ContactAction.php")
            ->findAll();

        return array('contact_actions' => $contact_actions);
    }

    /**
     * Get all the ContactActions with specified type
     * @param Type $type
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get all the ContactActions with specified type",
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
     * @ParamConverter("type", class="GRCBundle:ContactActionType")
     * @Get("/contact_actions/type/{id}", requirements={"id" = "\d+"})
     */
    public function getContactActionsByTypeAction(Type $type)
    {

        $contact_actions = $this->getDoctrine()->getRepository("ContactAction.php")
            ->findBy(['type' => $type]);

        return array('contact_actions' => $contact_actions);
    }

    /**
     * Get all the ContactActions of a specified contact
     * @param Contact $contact
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get all the ContactActions of a specified contact",
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
     * @ParamConverter("contact", class="GRCBundle:Contact")
     * @Get("/contact_actions/contact/{id}", requirements={"id" = "\d+"})
     */
    public function getContactActionsByContactAction(Contact $contact)
    {

        $contact_actions = $this->getDoctrine()->getRepository("ContactAction.php")
            ->findBy(['contact' => $contact]);

        return array('contact_actions' => $contact_actions);
    }

    /**
     * Get all the ContactActions of a prospector
     * @param User $prospector
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get all ContactActions of a prospector",
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
     * @ParamConverter("prospector", class="KernelBundle:User")
     * @Get("/contact_actions/prospector/{id}", requirements={"id" = "\d+"})
     */
    public function getContactActionsByProspectorAction(User $prospector)
    {

        $contact_actions = $this->getDoctrine()->getRepository("ContactAction.php")
            ->findBy(['prospector' => $prospector]);

        return array('contact_actions' => $contact_actions);
    }

    /**
     * Get all the ContactActions of current user
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get all ContactActions of current user",
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
     * @Get("/contact_actions/current")
     */
    public function getCurrentUserContactActionsAction()
    {

        $contact_actions = $this->getDoctrine()->getRepository("ContactAction.php")
            ->findBy(['prospector' => $this->getUser()]);

        return array('contact_actions' => $contact_actions);
    }

    /**
     * Get a ContactAction by ID
     * @param ContactAction $contact_action
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Get a ContactAction",
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
     * @ParamConverter("contact_action", class="GRCBundle:ContactAction")
     * @Get("/contact_action/{id}", requirements={"id" = "\d+"})
     */
    public function getContactActionAction(ContactAction $contact_action)
    {

        return array('contact_action' => $contact_action);

    }

    /**
     * Create a new ContactAction
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Create a new ContactAction",
     *  input="GRCBundle\Form\ContactActionType",
     *  output="GRCBundle\Entity\ContactAction",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/contact_action")
     */
    public function postContactActionAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_ADMIN');

        $contact_action = new ContactAction();
        $form = $this->createForm(new ContactActionType(), $contact_action);
        $form->handleRequest($request);

        if (!$this->get('grc.contact.rights_service')->userHasRights($this->getUser(), $contact_action->getContact())) {
            throw new AccessDeniedException();
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact_action);
            $em->flush();

            return array("contact_action" => $contact_action);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a ContactAction
     * Put action
     * @var Request $request
     * @var ContactAction $contact_action
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Edit a ContactAction",
     *  input="GRCBundle\Form\ContactActionType",
     *  output="GRCBundle\Entity\ContactAction",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact_action", class="GRCBundle:ContactAction")
     * @Post("/contact_action/{id}", requirements={"id" = "\d+"})
     */
    public function putContactActionAction(Request $request, ContactAction $contact_action)
    {
        if (!$this->get('grc.contact.rights_service')->userHasRights($this->getUser(), $contact_action->getContact())) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new ContactActionType(), $contact_action);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($contact_action);
            $em->flush();

            return array("contact_action" => $contact_action);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ContactAction
     * Delete action
     * @var ContactAction $contact_action
     * @return array
     *
     * @ApiDoc(
     *  section="ContactAction",
     *  description="Delete a ContactAction",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("contact_action", class="GRCBundle:ContactAction")
     * @Delete("/contact_action/{id}", requirements={"id" = "\d+"})
     */
    public function deleteContactActionAction(ContactAction $contact_action)
    {
        if (!$this->get('grc.contact.rights_service')->userHasRights($this->getUser(), $contact_action->getContact())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact_action);
        $em->flush();

        return array("status" => "Deleted");
    }

}
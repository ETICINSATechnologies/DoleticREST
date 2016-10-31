<?php

namespace SupportBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use SupportBundle\Entity\TicketType;
use SupportBundle\Form\TicketTypeType;

class TicketTypeController extends FOSRestController
{

    /**
     * Get all the ticket_types
     * @return array
     *
     * @ApiDoc(
     *  section="TicketType",
     *  description="Get all ticket_types",
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
     * @Get("/ticket_types")
     */
    public function getTicketTypesAction()
    {

        $ticket_types = $this->getDoctrine()->getRepository("SupportBundle:TicketType")
            ->findAll();

        return array('ticket_types' => $ticket_types);
    }

    /**
     * Get a ticket_type by ID
     * @param TicketType $ticket_type
     * @return array
     *
     * @ApiDoc(
     *  section="TicketType",
     *  description="Get a ticket_type",
     *  requirements={
     *      {
     *          "name"="ticket_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_type id"
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
     * @ParamConverter("ticket_type", class="SupportBundle:TicketType")
     * @Get("/ticket_type/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketTypeAction(TicketType $ticket_type)
    {

        return array('ticket_type' => $ticket_type);

    }

    /**
     * Get a ticket_type by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="TicketType",
     *  description="Get a ticket_type",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_type label"
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
     * @Get("/ticket_type/{label}")
     */
    public function getTicketTypeByLabelAction($label)
    {

        $ticket_type = $this->getDoctrine()->getRepository('SupportBundle:TicketType')->findOneBy(['label' => $label]);
        return array('ticket_type' => $ticket_type);
    }

    /**
     * Create a new TicketType
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="TicketType",
     *  description="Create a new TicketType",
     *  input="SupportBundle\Form\TicketTypeType",
     *  output="SupportBundle\Entity\TicketType",
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
     * @Post("/ticket_type")
     */
    public function postTicketTypeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_SUPERADMIN');

        $ticket_type = new TicketType();
        $form = $this->createForm(new TicketTypeType(), $ticket_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket_type);
            $em->flush();

            return array("ticket_type" => $ticket_type);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a TicketType
     * Put action
     * @var Request $request
     * @var TicketType $ticket_type
     * @return array
     *
     * @ApiDoc(
     *  section="TicketType",
     *  description="Edit a TicketType",
     *  requirements={
     *      {
     *          "name"="ticket_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="ticket_type id"
     *      }
     *  },
     *  input="SupportBundle\Form\TicketTypeType",
     *  output="SupportBundle\Entity\TicketType",
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
     * @ParamConverter("ticket_type", class="SupportBundle:TicketType")
     * @Post("/ticket_type/{id}")
     */
    public function putTicketTypeAction(Request $request, TicketType $ticket_type)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_SUPERADMIN');

        $form = $this->createForm(new TicketTypeType(), $ticket_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket_type);
            $em->flush();

            return array("ticket_type" => $ticket_type);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a TicketType
     * Delete action
     * @var TicketType $ticket_type
     * @return array
     *
     * @View()
     * @ParamConverter("ticket_type", class="SupportBundle:TicketType")
     * @Delete("/ticket_type/{id}")
     */
    public function deleteTicketTypeAction(TicketType $ticket_type)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
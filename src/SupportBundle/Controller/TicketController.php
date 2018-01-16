<?php

namespace SupportBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SupportBundle\Entity\TicketStatus;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use SupportBundle\Entity\Ticket;
use SupportBundle\Form\TicketType;
use SupportBundle\Entity\TicketType as Type;

class TicketController extends FOSRestController
{

    /**
     * Get all the tickets
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Get("/tickets")
     */
    public function getTicketsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_ADMIN');

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findAll();

        $array = [];
        foreach ($tickets as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the tickets of a type
     * @param Type $type
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets of a type",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("type", class="SupportBundle:TicketType")
     * @Get("/tickets/type/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketsByTypeAction(Type $type)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_ADMIN');

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findBy(['type' => $type]);

        $array = [];
        foreach ($tickets as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the tickets at a given status
     * @param TicketStatus $status
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets at a given status",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("status", class="SupportBundle:TicketStatus")
     * @Get("/tickets/status/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketsByStatusAction(TicketStatus $status)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_ADMIN');

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findBy(['status' => $status]);

        $array = [];
        foreach ($tickets as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the tickets by an author
     * @param User $author
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets by an author",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("author", class="KernelBundle:User")
     * @Get("/tickets/author/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketsByAuthorAction(User $author)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_ADMIN');

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findBy(['author' => $author]);

        $array = [];
        foreach ($tickets as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the tickets by current user
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get all tickets by current user",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/tickets/current")
     */
    public function getCurrentUserTicketsAction()
    {

        $tickets = $this->getDoctrine()->getRepository("SupportBundle:Ticket")
            ->findBy(['author' => $this->getUser()]);

        $array = [];
        foreach ($tickets as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a ticket by ID
     * @param Ticket $ticket
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Get a ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Get("/ticket/{id}", requirements={"id" = "\d+"})
     */
    public function getTicketAction(Ticket $ticket)
    {

        $this->denyAccessUnlessGranted('ROLE_SUPPORT_ADMIN');

        return $ticket;

    }

    /**
     * Create a new Ticket
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Create a new Ticket",
     *  input="SupportBundle\Form\TicketType",
     *  output="SupportBundle\Entity\Ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Post("/ticket")
     */
    public function postTicketAction(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm(new TicketType(), $ticket);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            return $ticket;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Ticket
     * Put action
     * @var Request $request
     * @var Ticket $ticket
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Edit a Ticket",
     *  input="SupportBundle\Form\TicketType",
     *  output="SupportBundle\Entity\Ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Post("/ticket/{id}", requirements={"id" = "\d+"})
     */
    public function putTicketAction(Request $request, Ticket $ticket)
    {
        if ($this->getUser()->getId() !== $ticket->getAuthor()->getId()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new TicketType(), $ticket);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket);
            $em->flush();

            return $ticket;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Ticket
     * Delete action
     * @var Ticket $ticket
     * @return array
     *
     * @ApiDoc(
     *  section="Ticket",
     *  description="Delete a Ticket",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("ticket", class="SupportBundle:Ticket")
     * @Delete("/ticket/{id}", requirements={"id" = "\d+"})
     */
    public function deleteTicketAction(Ticket $ticket)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPPORT_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();

        return array("status" => "Deleted");
    }

}
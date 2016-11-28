<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use RHBundle\Entity\RecruitmentEvent;
use RHBundle\Form\RecruitmentEventType;

class RecruitmentEventController extends FOSRestController
{

    /**
     * Get all the recruitment_events
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get all recruitment_events",
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
     * @Get("/recruitment_events")
     */
    public function getRecruitmentEventsAction(){

        $recruitment_events = $this->getDoctrine()->getRepository("RHBundle:RecruitmentEvent")
            ->findAll();

        return array('recruitment_events' => $recruitment_events);
    }

    /**
     * Get a recruitment_event by ID
     * @param RecruitmentEvent $recruitment_event
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get a recruitment_event",
     *  requirements={
     *      {
     *          "name"="recruitment_event",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment_event id"
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
     * @ParamConverter("recruitment_event", class="RHBundle:RecruitmentEvent")
     * @Get("/recruitment_event/{id}", requirements={"id" = "\d+"})
     */
    public function getRecruitmentEventAction(RecruitmentEvent $recruitment_event){

        return array('recruitment_event' => $recruitment_event);

    }

    /**
     * Get a recruitment_event by date
     * @param string $date
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get a recruitment_event",
     *  requirements={
     *      {
     *          "name"="date",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment_event date"
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
     * @Get("/recruitment_event/{date}")
     */
    public function getRecruitmentEventByDateAction($date){

        $recruitment_event = $this->getDoctrine()->getRepository('RHBundle:RecruitmentEvent')->findOneBy(['date' => $date]);
        return array('recruitment_event' => $recruitment_event);
    }

    /**
     * Create a new RecruitmentEvent
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Create a new RecruitmentEvent",
     *  input="RHBundle\Form\RecruitmentEventType",
     *  output="RHBundle\Entity\RecruitmentEvent",
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
     * @Post("/recruitment_event")
     */
    public function postRecruitmentEventAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $recruitment_event = new RecruitmentEvent();
        $form = $this->createForm(new RecruitmentEventType(), $recruitment_event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitment_event);
            $em->flush();

            return array("recruitment_event" => $recruitment_event);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a RecruitmentEvent
     * Put action
     * @var Request $request
     * @var RecruitmentEvent $recruitment_event
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Edit a RecruitmentEvent",
     *  requirements={
     *      {
     *          "name"="recruitment_event",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment_event id"
     *      }
     *  },
     *  input="RHBundle\Form\RecruitmentEventType",
     *  output="RHBundle\Entity\RecruitmentEvent",
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
     * @ParamConverter("recruitment_event", class="RHBundle:RecruitmentEvent")
     * @Post("/recruitment_event/{id}")
     */
    public function putRecruitmentEventAction(Request $request, RecruitmentEvent $recruitment_event)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new RecruitmentEventType(), $recruitment_event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($recruitment_event);
            $em->flush();

            return array("recruitment_event" => $recruitment_event);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a RecruitmentEvent
     * Delete action
     * @var RecruitmentEvent $recruitment_event
     * @return array
     *
     * @View()
     * @ParamConverter("recruitment_event", class="RHBundle:RecruitmentEvent")
     * @Delete("/recruitment_event/{id}")
     */
    public function deleteRecruitmentEventAction(RecruitmentEvent $recruitment_event)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($recruitment_event);
        $em->flush();

        return array("status" => "Deleted");
    }

}
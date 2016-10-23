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
     * Get all the recruitments
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get all recruitments",
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
     * @Get("/recruitments")
     */
    public function getRecruitmentEventsAction(){

        $recruitments = $this->getDoctrine()->getRepository("RHBundle:RecruitmentEvent")
            ->findAll();

        return array('recruitments' => $recruitments);
    }

    /**
     * Get a recruitment by ID
     * @param RecruitmentEvent $recruitment
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get a recruitment",
     *  requirements={
     *      {
     *          "name"="recruitment",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment id"
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
     * @ParamConverter("recruitment", class="RHBundle:RecruitmentEvent")
     * @Get("/recruitment/{id}", requirements={"id" = "\d+"})
     */
    public function getRecruitmentEventAction(RecruitmentEvent $recruitment){

        return array('recruitment' => $recruitment);

    }

    /**
     * Get a recruitment by date
     * @param string $date
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Get a recruitment",
     *  requirements={
     *      {
     *          "name"="date",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment date"
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
     * @Get("/recruitment/{date}")
     */
    public function getRecruitmentEventByDateAction($date){

        $recruitment = $this->getDoctrine()->getRepository('RHBundle:RecruitmentEvent')->findOneBy(['date' => $date]);
        return array('recruitment' => $recruitment);
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
     * @Post("/recruitment")
     */
    public function postRecruitmentEventAction(Request $request)
    {
        $recruitment = new RecruitmentEvent();
        $form = $this->createForm(new RecruitmentEventType(), $recruitment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitment);
            $em->flush();

            return array("recruitment" => $recruitment);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a RecruitmentEvent
     * Put action
     * @var Request $request
     * @var RecruitmentEvent $recruitment
     * @return array
     *
     * @ApiDoc(
     *  section="RecruitmentEvent",
     *  description="Edit a RecruitmentEvent",
     *  requirements={
     *      {
     *          "name"="recruitment",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="recruitment id"
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
     * @ParamConverter("recruitment", class="RHBundle:RecruitmentEvent")
     * @Put("/recruitment/{id}")
     */
    public function putRecruitmentEventAction(Request $request, RecruitmentEvent $recruitment)
    {
        $form = $this->createForm(new RecruitmentEventType(), $recruitment);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($recruitment);
            $em->flush();

            return array("recruitment" => $recruitment);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a RecruitmentEvent
     * Delete action
     * @var RecruitmentEvent $recruitment
     * @return array
     *
     * @View()
     * @ParamConverter("recruitment", class="RHBundle:RecruitmentEvent")
     * @Delete("/recruitment/{id}")
     */
    public function deleteRecruitmentEventAction(RecruitmentEvent $recruitment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($recruitment);
        $em->flush();

        return array("status" => "Deleted");
    }

}
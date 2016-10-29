<?php

namespace UABundle\Controller;


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
use UABundle\Entity\Consultant;
use UABundle\Entity\Project;
use UABundle\Form\ConsultantType;

class ConsultantController extends FOSRestController
{

    /**
     * Get all the consultants
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants",
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
     * @Get("/consultants")
     */
    public function getConsultantsAction()
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy([], ['number' => 'ASC']);

        return array('consultants' => $consultants);
    }

    /**
     * Get all the consultants in a project
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants in a project",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/consultants/project/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantsByProjectAction(Project $project)
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy(['project' => $project]);

        return array('consultants' => $consultants);
    }

    /**
     * Get all the consultants linked to a user data
     * @param UserData $userData
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get all consultants linked to a user data",
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
     * @ParamConverter("userData", class="KernelBundle:UserData")
     * @Get("/consultants/user_data/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantsByUserDataAction(UserData $userData)
    {

        $consultants = $this->getDoctrine()->getRepository("UABundle:Consultant")
            ->findBy(['userData' => $userData]);

        return array('consultants' => $consultants);
    }

    /**
     * Get a consultant by ID
     * @param Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Get a consultant",
     *  requirements={
     *      {
     *          "name"="consultant",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="consultant id"
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Get("/consultant/{id}", requirements={"id" = "\d+"})
     */
    public function getConsultantAction(Consultant $consultant)
    {

        return array('consultant' => $consultant);

    }

    /**
     * Create a new Consultant
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Create a new Consultant",
     *  input="UABundle\Form\ConsultantType",
     *  output="UABundle\Entity\Consultant",
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
     * @Post("/consultant")
     */
    public function postConsultantAction(Request $request)
    {
        $consultant = new Consultant();
        $form = $this->createForm(new ConsultantType(), $consultant);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($consultant);
            $em->flush();

            return array("consultant" => $consultant);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Consultant
     * Put action
     * @var Request $request
     * @var Consultant $consultant
     * @return array
     *
     * @ApiDoc(
     *  section="Consultant",
     *  description="Edit a Consultant",
     *  requirements={
     *      {
     *          "name"="consultant",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="consultant id"
     *      }
     *  },
     *  input="UABundle\Form\ConsultantType",
     *  output="UABundle\Entity\Consultant",
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
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Put("/consultant/{id}")
     */
    public function putConsultantAction(Request $request, Consultant $consultant)
    {
        $form = $this->createForm(new ConsultantType(), $consultant);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($consultant);
            $em->flush();

            return array("consultant" => $consultant);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Consultant
     * Delete action
     * @var Consultant $consultant
     * @return array
     *
     * @View()
     * @ParamConverter("consultant", class="UABundle:Consultant")
     * @Delete("/consultant/{id}")
     */
    public function deleteConsultantAction(Consultant $consultant)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultant);
        $em->flush();

        return array("status" => "Deleted");
    }

}
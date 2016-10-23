<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Amendment;
use UABundle\Form\AmendmentType;

class AmendmentController extends FOSRestController
{

    /**
     * Get all the amendments
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get all amendments",
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
     * @Get("/amendments")
     */
    public function getAmendmentsAction(){

        $amendments = $this->getDoctrine()->getRepository("UABundle:Amendment")
            ->findAll();

        return array('amendments' => $amendments);
    }

    /**
     * Get a amendment by ID
     * @param Amendment $amendment
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get a amendment",
     *  requirements={
     *      {
     *          "name"="amendment",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="amendment id"
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
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Get("/amendment/{id}", requirements={"id" = "\d+"})
     */
    public function getAmendmentAction(Amendment $amendment){

        return array('amendment' => $amendment);

    }

    /**
     * Create a new Amendment
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Create a new Amendment",
     *  input="UABundle\Form\AmendmentType",
     *  output="UABundle\Entity\Amendment",
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
     * @Post("/amendment")
     */
    public function postAmendmentAction(Request $request)
    {
        $amendment = new Amendment();
        $form = $this->createForm(new AmendmentType(), $amendment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amendment);
            $em->flush();

            return array("amendment" => $amendment);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Amendment
     * Put action
     * @var Request $request
     * @var Amendment $amendment
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Edit a Amendment",
     *  requirements={
     *      {
     *          "name"="amendment",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="amendment id"
     *      }
     *  },
     *  input="UABundle\Form\AmendmentType",
     *  output="UABundle\Entity\Amendment",
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
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Put("/amendment/{id}")
     */
    public function putAmendmentAction(Request $request, Amendment $amendment)
    {
        $form = $this->createForm(new AmendmentType(), $amendment);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($amendment);
            $em->flush();

            return array("amendment" => $amendment);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Amendment
     * Delete action
     * @var Amendment $amendment
     * @return array
     *
     * @View()
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Delete("/amendment/{id}")
     */
    public function deleteAmendmentAction(Amendment $amendment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($amendment);
        $em->flush();

        return array("status" => "Deleted");
    }

}
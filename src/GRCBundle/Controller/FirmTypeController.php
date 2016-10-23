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
use GRCBundle\Entity\FirmType;
use GRCBundle\Form\FirmTypeType;

class FirmTypeController extends FOSRestController
{

    /**
     * Get all the firm_types
     * @return array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Get all firm_types",
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
     * @Get("/firm_types")
     */
    public function getFirmTypesAction(){

        $firm_types = $this->getDoctrine()->getRepository("GRCBundle:FirmType")
            ->findAll();

        return array('firm_types' => $firm_types);
    }

    /**
     * Get a firm_type by ID
     * @param FirmType $firm_type
     * @return array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Get a firm_type",
     *  requirements={
     *      {
     *          "name"="firm_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm_type id"
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
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Get("/firm_type/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmTypeAction(FirmType $firm_type){

        return array('firm_type' => $firm_type);

    }

    /**
     * Get a firm_type by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Get a firm_type",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm_type label"
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
     * @Get("/firm_type/{label}")
     */
    public function getFirmTypeByLabelAction($label){

        $firm_type = $this->getDoctrine()->getRepository('GRCBundle:FirmType')->findOneBy(['label' => $label]);
        return array('firm_type' => $firm_type);
    }

    /**
     * Create a new FirmType
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Create a new FirmType",
     *  input="GRCBundle\Form\FirmTypeType",
     *  output="GRCBundle\Entity\FirmType",
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
     * @Post("/firm_type")
     */
    public function postFirmTypeAction(Request $request)
    {
        $firm_type = new FirmType();
        $form = $this->createForm(new FirmTypeType(), $firm_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firm_type);
            $em->flush();

            return array("firm_type" => $firm_type);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a FirmType
     * Put action
     * @var Request $request
     * @var FirmType $firm_type
     * @return array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Edit a FirmType",
     *  requirements={
     *      {
     *          "name"="firm_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm_type id"
     *      }
     *  },
     *  input="GRCBundle\Form\FirmTypeType",
     *  output="GRCBundle\Entity\FirmType",
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
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Put("/firm_type/{id}")
     */
    public function putFirmTypeAction(Request $request, FirmType $firm_type)
    {
        $form = $this->createForm(new FirmTypeType(), $firm_type);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($firm_type);
            $em->flush();

            return array("firm_type" => $firm_type);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a FirmType
     * Delete action
     * @var FirmType $firm_type
     * @return array
     *
     * @View()
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Delete("/firm_type/{id}")
     */
    public function deleteFirmTypeAction(FirmType $firm_type)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($firm_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
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
     *   "grc" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/firm_types")
     */
    public function getFirmTypesAction()
    {

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
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Get("/firm_type/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmTypeAction(FirmType $firm_type)
    {

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
     * @Get("/firm_type/{label}")
     */
    public function getFirmTypeByLabelAction($label)
    {

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
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/firm_type")
     */
    public function postFirmTypeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

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
     *  input="GRCBundle\Form\FirmTypeType",
     *  output="GRCBundle\Entity\FirmType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Post("/firm_type/{id}", requirements={"id" = "\d+"})
     */
    public function putFirmTypeAction(Request $request, FirmType $firm_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

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
     * Delete a FirmType
     * Delete action
     * @var FirmType $firm_type
     * @return array
     *
     * @ApiDoc(
     *  section="FirmType",
     *  description="Delete a FirmType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "grc" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("firm_type", class="GRCBundle:FirmType")
     * @Delete("/firm_type/{id}")
     */
    public function deleteFirmTypeAction(FirmType $firm_type)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($firm_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
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
use GRCBundle\Entity\Firm;
use GRCBundle\Form\FirmType;

class FirmController extends FOSRestController
{

    /**
     * Get all the firms
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get all firms",
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
     * @Get("/firms")
     */
    public function getFirmsAction(){

        $firms = $this->getDoctrine()->getRepository("GRCBundle:Firm")
            ->findAll();

        return array('firms' => $firms);
    }

    /**
     * Get a firm by ID
     * @param Firm $firm
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get a firm",
     *  requirements={
     *      {
     *          "name"="firm",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm id"
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
     * @Get("/firm/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmAction(Firm $firm){

        return array('firm' => $firm);

    }

    /**
     * Get a firm by name
     * @param string $name
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get a firm",
     *  requirements={
     *      {
     *          "name"="name",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm name"
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
     * @Get("/firm/{name}")
     */
    public function getFirmByLabelAction($name){

        $firm = $this->getDoctrine()->getRepository('GRCBundle:Firm')->findOneBy(['name' => $name]);
        return array('firm' => $firm);
    }

    /**
     * Create a new Firm
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Create a new Firm",
     *  input="GRCBundle\Form\FirmType",
     *  output="GRCBundle\Entity\Firm",
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
     * @Post("/firm")
     */
    public function postFirmAction(Request $request)
    {
        $firm = new Firm();
        $form = $this->createForm(new FirmType(), $firm);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firm);
            $em->flush();

            return array("firm" => $firm);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Firm
     * Put action
     * @var Request $request
     * @var Firm $firm
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Edit a Firm",
     *  requirements={
     *      {
     *          "name"="firm",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="firm id"
     *      }
     *  },
     *  input="GRCBundle\Form\FirmType",
     *  output="GRCBundle\Entity\Firm",
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Put("/firm/{id}")
     */
    public function putFirmAction(Request $request, Firm $firm)
    {
        $form = $this->createForm(new FirmType(), $firm);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($firm);
            $em->flush();

            return array("firm" => $firm);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Firm
     * Delete action
     * @var Firm $firm
     * @return array
     *
     * @View()
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Delete("/firm/{id}")
     */
    public function deleteFirmAction(Firm $firm)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($firm);
        $em->flush();

        return array("status" => "Deleted");
    }

}
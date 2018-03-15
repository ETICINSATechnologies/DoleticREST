<?php

namespace GRCBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\Country;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use GRCBundle\Entity\Firm;
use GRCBundle\Entity\FirmType as Type;
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
     *   "grc" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/firms")
     */
    public function getFirmsAction()
    {


        $firms = $this->getDoctrine()->getRepository("GRCBundle:Firm")
            ->getFirmsForTab();

        /*$array = [];
        foreach ($firms as $c){
            $array[] =$c;
        }*/

        return $firms;
    }

    /**
     * Get all the firms with specified type
     * @param Type $type
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get all the firms with specified type",
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
     * @ParamConverter("type", class="GRCBundle:FirmType")
     * @Get("/firms/type/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmsByTypeAction(Type $type)
    {

        $firms = $this->getDoctrine()->getRepository("GRCBundle:Firm")
            ->findBy(['type' => $type]);

        $array = [];
        foreach ($firms as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the firms with specified type
     * @param Country $country
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get all the firms from specified country",
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
     * @ParamConverter("country", class="KernelBundle:Country")
     * @Get("/firms/country/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmsByCountryAction(Country $country)
    {

        $firms = $this->getDoctrine()->getRepository("GRCBundle:Firm")
            ->findBy(['country' => $country]);

        $array = [];
        foreach ($firms as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a firm by ID
     * @param Firm $firm
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get a firm",
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Get("/firm/{id}", requirements={"id" = "\d+"})
     */
    public function getFirmAction(Firm $firm)
    {

        return $firm;

    }

    /**
     * Get a firm by name
     * @param string $name
     * @return array
     *
     * @ApiDoc(
     *  section="Firm",
     *  description="Get a firm",
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
     * @Get("/firm/{name}")
     */
    public function getFirmByNameAction($name)
    {

        $firm = $this->getDoctrine()->getRepository('GRCBundle:Firm')->findOneBy(['name' => $name]);
        return $firm;
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
     *   "grc" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/firm")
     */
    public function postFirmAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_ADMIN');

        $firm = new Firm();
        $form = $this->createForm(new FirmType(), $firm);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($firm);
            $em->flush();

            return $firm;

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
     *  input="GRCBundle\Form\FirmType",
     *  output="GRCBundle\Entity\Firm",
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Post("/firm/{id}", requirements={"id" = "\d+"})
     */
    public function putFirmAction(Request $request, Firm $firm)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_ADMIN');

        $form = $this->createForm(new FirmType(), $firm);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($firm);
            $em->flush();

            return $firm;
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
     * @ApiDoc(
     *  section="Firm",
     *  description="Delete a Firm",
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
     * @ParamConverter("firm", class="GRCBundle:Firm")
     * @Delete("/firm/{id}", requirements={"id" = "\d+"})
     */
    public function deleteFirmAction(Firm $firm)
    {
        $this->denyAccessUnlessGranted('ROLE_GRC_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($firm);
        $em->flush();

        return array("status" => "Deleted");
    }

}
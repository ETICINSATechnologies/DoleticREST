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
use RHBundle\Entity\SchoolYear;
use RHBundle\Form\SchoolYearType;

class SchoolYearController extends FOSRestController
{

    /**
     * Get all the years
     * @return array
     *
     * @ApiDoc(
     *  section="SchoolYear",
     *  description="Get all years",
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
     * @Get("/years")
     */
    public function getSchoolYearsAction(){

        $years = $this->getDoctrine()->getRepository("RHBundle:SchoolYear")
            ->findAll();

        return array('years' => $years);
    }

    /**
     * Get a year by ID
     * @param SchoolYear $year
     * @return array
     *
     * @ApiDoc(
     *  section="SchoolYear",
     *  description="Get a year",
     *  requirements={
     *      {
     *          "name"="year",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="year id"
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
     * @ParamConverter("year", class="RHBundle:SchoolYear")
     * @Get("/year/{id}", requirements={"id" = "\d+"})
     */
    public function getSchoolYearAction(SchoolYear $year){

        return array('year' => $year);

    }

    /**
     * Get a year by year
     * @param string $year
     * @return array
     *
     * @ApiDoc(
     *  section="SchoolYear",
     *  description="Get a year",
     *  requirements={
     *      {
     *          "name"="year",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="year year"
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
     * @Get("/year/{year}")
     */
    public function getSchoolYearByYearAction($year){

        $year = $this->getDoctrine()->getRepository('RHBundle:SchoolYear')->findOneBy(['year' => $year]);
        return array('year' => $year);
    }

    /**
     * Create a new SchoolYear
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="SchoolYear",
     *  description="Create a new SchoolYear",
     *  input="RHBundle\Form\SchoolYearType",
     *  output="RHBundle\Entity\SchoolYear",
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
     * @Post("/year")
     */
    public function postSchoolYearAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $year = new SchoolYear();
        $form = $this->createForm(new SchoolYearType(), $year);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($year);
            $em->flush();

            return array("year" => $year);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a SchoolYear
     * Put action
     * @var Request $request
     * @var SchoolYear $year
     * @return array
     *
     * @ApiDoc(
     *  section="SchoolYear",
     *  description="Edit a SchoolYear",
     *  requirements={
     *      {
     *          "name"="year",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="year id"
     *      }
     *  },
     *  input="RHBundle\Form\SchoolYearType",
     *  output="RHBundle\Entity\SchoolYear",
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
     * @ParamConverter("year", class="RHBundle:SchoolYear")
     * @Put("/year/{id}")
     */
    public function putSchoolYearAction(Request $request, SchoolYear $year)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new SchoolYearType(), $year);
        $form->submit($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($year);
            $em->flush();

            return array("year" => $year);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a SchoolYear
     * Delete action
     * @var SchoolYear $year
     * @return array
     *
     * @View()
     * @ParamConverter("year", class="RHBundle:SchoolYear")
     * @Delete("/year/{id}")
     */
    public function deleteSchoolYearAction(SchoolYear $year)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($year);
        $em->flush();

        return array("status" => "Deleted");
    }

}
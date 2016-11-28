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
use UABundle\Entity\AmendmentType;
use UABundle\Form\AmendmentTypeType;

class AmendmentTypeController extends FOSRestController
{

    /**
     * Get all the amendment_types
     * @return array
     *
     * @ApiDoc(
     *  section="AmendmentType",
     *  description="Get all amendment_types",
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
     * @Get("/amendment_types")
     */
    public function getAmendmentTypesAction()
    {

        $amendment_types = $this->getDoctrine()->getRepository("UABundle:AmendmentType")
            ->findAll();

        return array('amendment_types' => $amendment_types);
    }

    /**
     * Get a amendment_type by ID
     * @param AmendmentType $amendment_type
     * @return array
     *
     * @ApiDoc(
     *  section="AmendmentType",
     *  description="Get a amendment_type",
     *  requirements={
     *      {
     *          "name"="amendment_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="amendment_type id"
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
     * @ParamConverter("amendment_type", class="UABundle:AmendmentType")
     * @Get("/amendment_type/{id}", requirements={"id" = "\d+"})
     */
    public function getAmendmentTypeAction(AmendmentType $amendment_type)
    {

        return array('amendment_type' => $amendment_type);

    }

    /**
     * Get a amendment_type by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="AmendmentType",
     *  description="Get a amendment_type",
     *  requirements={
     *      {
     *          "name"="label",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="amendment_type label"
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
     * @Get("/amendment_type/{label}")
     */
    public function getAmendmentTypeByLabelAction($label)
    {

        $amendment_type = $this->getDoctrine()->getRepository('UABundle:AmendmentType')->findOneBy(['label' => $label]);
        return array('amendment_type' => $amendment_type);
    }

    /**
     * Create a new AmendmentType
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="AmendmentType",
     *  description="Create a new AmendmentType",
     *  input="UABundle\Form\AmendmentTypeType",
     *  output="UABundle\Entity\AmendmentType",
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
     * @Post("/amendment_type")
     */
    public function postAmendmentTypeAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $amendment_type = new AmendmentType();
        $form = $this->createForm(new AmendmentTypeType(), $amendment_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($amendment_type);
            $em->flush();

            return array("amendment_type" => $amendment_type);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a AmendmentType
     * Put action
     * @var Request $request
     * @var AmendmentType $amendment_type
     * @return array
     *
     * @ApiDoc(
     *  section="AmendmentType",
     *  description="Edit a AmendmentType",
     *  requirements={
     *      {
     *          "name"="amendment_type",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="amendment_type id"
     *      }
     *  },
     *  input="UABundle\Form\AmendmentTypeType",
     *  output="UABundle\Entity\AmendmentType",
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
     * @ParamConverter("amendment_type", class="UABundle:AmendmentType")
     * @Post("/amendment_type/{id}")
     */
    public function putAmendmentTypeAction(Request $request, AmendmentType $amendment_type)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $form = $this->createForm(new AmendmentTypeType(), $amendment_type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($amendment_type);
            $em->flush();

            return array("amendment_type" => $amendment_type);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a AmendmentType
     * Delete action
     * @var AmendmentType $amendment_type
     * @return array
     *
     * @View()
     * @ParamConverter("amendment_type", class="UABundle:AmendmentType")
     * @Delete("/amendment_type/{id}")
     */
    public function deleteAmendmentTypeAction(AmendmentType $amendment_type)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($amendment_type);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace KernelBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use KernelBundle\Entity\Gender;
use KernelBundle\Form\GenderType;

class GenderController extends FOSRestController
{

    /**
     * Get all the genders
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Get all genders",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Get("/genders")
     */
    public function getGendersAction()
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $genders = $this->getDoctrine()->getRepository("KernelBundle:Gender")
            ->findAll();

        return array('genders' => $genders);
    }

    /**
     * Get all the enabled genders
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Get all enabled genders",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/genders/enabled")
     */
    public function getEnabledGendersAction()
    {

        $genders = $this->getDoctrine()->getRepository("KernelBundle:Gender")
            ->findBy(['enabled' => true]);

        return array('genders' => $genders);
    }

    /**
     * Get a gender by ID
     * @param Gender $gender
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Get a gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("gender", class="KernelBundle:Gender")
     * @Get("/gender/{id}", requirements={"id" = "\d+"})
     */
    public function getGenderAction(Gender $gender)
    {

        return array('gender' => $gender);

    }

    /**
     * Get a gender by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Get a gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/gender/{label}")
     */
    public function getGenderByLabelAction($label)
    {

        $gender = $this->getDoctrine()->getRepository('KernelBundle:Gender')->findOneBy(['label' => $label]);
        return array('gender' => $gender);

    }

    /**
     * Create a new Gender
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Create a new Gender",
     *  input="KernelBundle\Form\GenderType",
     *  output="KernelBundle\Entity\Gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/gender")
     */
    public function postGenderAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $gender = new Gender();
        $form = $this->createForm(new GenderType(), $gender);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gender);
            $em->flush();

            return array("gender" => $gender);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Gender
     * Put action
     * @var Request $request
     * @var Gender $gender
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Edit a Gender",
     *  input="KernelBundle\Form\GenderType",
     *  output="KernelBundle\Entity\Gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("gender", class="KernelBundle:Gender")
     * @Post("/gender/{id}", requirements={"id" = "\d+"})
     */
    public function putGenderAction(Request $request, Gender $gender)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $form = $this->createForm(new GenderType(), $gender);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($gender);
            $em->flush();

            return array("gender" => $gender);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Disable a Gender
     * Put action
     * @var Request $request
     * @var Gender $gender
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Disable a Gender",
     *  output="KernelBundle\Entity\Gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("gender", class="KernelBundle:Gender")
     * @Post("/gender/{id}/disable", requirements={"id" = "\d+"})
     */
    public function disableGenderAction(Request $request, Gender $gender)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $gender->setEnabled(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($gender);
        $em->flush();

        return array("gender" => $gender);
    }

    /**
     * Enable a Gender
     * Put action
     * @var Request $request
     * @var Gender $gender
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Enable a Gender",
     *  output="KernelBundle\Entity\Gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("gender", class="KernelBundle:Gender")
     * @Post("/gender/{id}/enable", requirements={"id" = "\d+"})
     */
    public function enableGenderAction(Request $request, Gender $gender)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $gender->setEnabled(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($gender);
        $em->flush();

        return array("gender" => $gender);
    }

    /**
     * Delete a Gender
     * Delete action
     * @var Gender $gender
     * @return array
     *
     * @ApiDoc(
     *  section="Gender",
     *  description="Delete a Gender",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "kernel" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("gender", class="KernelBundle:Gender")
     * @Delete("/gender/{id}", requirements={"id" = "\d+"})
     */
    public function deleteGenderAction(Gender $gender)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($gender);
        $em->flush();

        return array("status" => "Deleted");
    }

}
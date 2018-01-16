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
use KernelBundle\Entity\Division;
use KernelBundle\Form\DivisionType;

class DivisionController extends FOSRestController
{

    /**
     * Get all the divisions
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Get all divisions",
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
     * @Get("/divisions")
     */
    public function getDivisionsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $divisions = $this->getDoctrine()->getRepository("KernelBundle:Division")
            ->findAll();

        $array = [];
        foreach ($divisions as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get all the enabled divisions
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Get all enabled divisions",
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
     * @Get("/divisions/enabled")
     */
    public function getEnabledDivisionsAction()
    {

        $divisions = $this->getDoctrine()->getRepository("KernelBundle:Division")
            ->findBy(['enabled' => true]);

        $array = [];
        foreach ($divisions as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a division by ID
     * @param Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Get a division",
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
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Get("/division/{id}", requirements={"id" = "\d+"})
     */
    public function getDivisionAction(Division $division)
    {

        return $division;

    }

    /**
     * Get a division by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Get a division",
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
     * @Get("/division/{label}")
     */
    public function getDivisionByLabelAction($label)
    {

        $division = $this->getDoctrine()->getRepository('KernelBundle:Division')->findOneBy(['label' => $label]);
        return $division;

    }

    /**
     * Create a new Division
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Create a new Division",
     *  input="KernelBundle\Form\DivisionType",
     *  output="KernelBundle\Entity\Division",
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
     * @Post("/division")
     */
    public function postDivisionAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $division = new Division();
        $form = $this->createForm(new DivisionType(), $division);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($division);
            $em->flush();

            return $division;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Division
     * Put action
     * @var Request $request
     * @var Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Edit a Division",
     *  input="KernelBundle\Form\DivisionType",
     *  output="KernelBundle\Entity\Division",
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
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Post("/division/{id}", requirements={"id" = "\d+"})
     */
    public function putDivisionAction(Request $request, Division $division)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $form = $this->createForm(new DivisionType(), $division);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($division);
            $em->flush();

            return $division;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Disable a Division
     * Put action
     * @var Request $request
     * @var Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Disable a Division",
     *  output="KernelBundle\Entity\Division",
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
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Post("/division/{id}/disable", requirements={"id" = "\d+"})
     */
    public function disableDivisionAction(Request $request, Division $division)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $division->setEnabled(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($division);
        $em->flush();

        return $division;
    }

    /**
     * Enable a Division
     * Put action
     * @var Request $request
     * @var Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Enable a Division",
     *  output="KernelBundle\Entity\Division",
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
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Post("/division/{id}/enable", requirements={"id" = "\d+"})
     */
    public function enableDivisionAction(Request $request, Division $division)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $division->setEnabled(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($division);
        $em->flush();

        return $division;
    }

    /**
     * Delete a Division
     * Delete action
     * @var Division $division
     * @return array
     *
     * @ApiDoc(
     *  section="Division",
     *  description="Delete a Division",
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
     * @ParamConverter("division", class="KernelBundle:Division")
     * @Delete("/division/{id}", requirements={"id" = "\d+"})
     */
    public function deleteDivisionAction(Division $division)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($division);
        $em->flush();

        return array("status" => "Deleted");
    }

}
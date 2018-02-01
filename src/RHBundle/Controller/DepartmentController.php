<?php

namespace RHBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use RHBundle\Entity\Department;
use RHBundle\Form\DepartmentType;

class DepartmentController extends FOSRestController
{
    /**
     * Get all the departments
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Get all departments",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Get("/departments")
     */
    public function getDepartmentsAction()
    {
        //$this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $departments = $this->getDoctrine()->getRepository("RHBundle:Department")
            ->findAll();

        $array = [];
        foreach ($departments as $c){
            $array[] =$c;
        }

        return $array;
    }


    /**
     * Get consultant repartition departments
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Get consultant repartition departments",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff"
     *  }
     * )
     *
     * @View()
     * @Get("/departments/consultants")
     */
    public function getDepartmentsConsultantRepartitionAction()
    {
        //$this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');
        return $this->getDoctrine()->getRepository("RHBundle:Department")->getDepartmentConsultantRepartition();
    }

    /**
     * Get all the enabled departments
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Get all enabled departments",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/departments/enabled")
     */
    public function getEnabledDepartmentsAction()
    {
        $departments = $this->getDoctrine()->getRepository("RHBundle:Department")
            ->findBy(['enabled' => true]);

        $array = [];
        foreach ($departments as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a department by ID
     * @param Department $department
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Get a department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("department", class="RHBundle:Department")
     * @Get("/department/{id}", requirements={"id" = "\d+"})
     */
    public function getDepartmentAction(Department $department)
    {

        return $department;

    }

    /**
     * Get a department by label
     * @param string $label
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Get a department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/department/{label}")
     */
    public function getDepartmentByLabelAction($label)
    {

        $department = $this->getDoctrine()->getRepository('RHBundle:Department')->findOneBy(['label' => $label]);
        return $department;
    }

    /**
     * Create a new Department
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Create a new Department",
     *  input="RHBundle\Form\DepartmentType",
     *  output="RHBundle\Entity\Department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/department")
     */
    public function postDepartmentAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $department = new Department();
        $form = $this->createForm(new DepartmentType(), $department);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            return $department;

        }

        return $form;
    }

    /**
     * Edit a Department
     * Put action
     * @var Request $request
     * @var Department $department
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Edit a Department",
     *  input="RHBundle\Form\DepartmentType",
     *  output="RHBundle\Entity\Department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("department", class="RHBundle:Department")
     * @Post("/department/{id}", requirements={"id" = "\d+"})
     */
    public function putDepartmentAction(Request $request, Department $department)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $form = $this->createForm(new DepartmentType(), $department);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($department);
            $em->flush();

            return $department;
        }

        return $form;
    }

    /**
     * Disable a Department
     * Put action
     * @var Request $request
     * @var Department $department
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Disable a Department",
     *  output="RHBundle\Entity\Department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("department", class="RHBundle:Department")
     * @Post("/department/{id}/disable", requirements={"id" = "\d+"})
     */
    public function disableDepartmentAction(Request $request, Department $department)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $department->setEnabled(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($department);
        $em->flush();

        return $department;
    }

    /**
     * Enable a Department
     * Put action
     * @var Request $request
     * @var Department $department
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Enable a Department",
     *  output="RHBundle\Entity\Department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("department", class="RHBundle:Department")
     * @Post("/department/{id}/enable", requirements={"id" = "\d+"})
     */
    public function enableDepartmentAction(Request $request, Department $department)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $department->setEnabled(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($department);
        $em->flush();

        return $department;
    }

    /**
     * Delete a Department
     * Delete action
     * @var Department $department
     * @return array
     *
     * @ApiDoc(
     *  section="Department",
     *  description="Delete a Department",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "rh" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("department", class="RHBundle:Department")
     * @Delete("/department/{id}", requirements={"id" = "\d+"})
     */
    public function deleteDepartmentAction(Department $department)
    {
        $this->denyAccessUnlessGranted('ROLE_RH_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($department);
        $em->flush();

        return array("status" => "Deleted");
    }

}
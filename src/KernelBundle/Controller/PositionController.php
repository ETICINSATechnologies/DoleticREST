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
use KernelBundle\Entity\Position;
use KernelBundle\Form\PositionType;

class PositionController extends FOSRestController
{

    /**
     * Get all the positions
     * @return array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Get all positions",
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
     * @Get("/positions")
     */
    public function getPositionsAction()
    {

        $positions = $this->getDoctrine()->getRepository("KernelBundle:Position")
            ->findAll();

        $array = [];
        foreach ($positions as $c){
            $array[] =$c;
        }

        return $array;
    }

    /**
     * Get a position by ID
     * @param Position $position
     * @return array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Get a position",
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
     * @ParamConverter("position", class="KernelBundle:Position")
     * @Get("/position/{id}", requirements={"id" = "\d+"})
     */
    public function getPositionAction(Position $position)
    {

        return $position;

    }

    /**
     * Get a position by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Get a position",
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
     * @Get("/position/{label}")
     */
    public function getPositionByLabelAction($label)
    {

        $position = $this->getDoctrine()->getRepository('KernelBundle:Position')->findOneBy(['label' => $label]);
        return $position;
    }

    /**
     * Create a new Position
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Create a new Position",
     *  input="KernelBundle\Form\PositionType",
     *  output="KernelBundle\Entity\Position",
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
     * @Post("/position")
     */
    public function postPositionAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $position = new Position();
        $form = $this->createForm(
            new PositionType(),
            $position,
            ['roles' => $this->container->getParameter('security.role_hierarchy.roles')]
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($position);
            $em->flush();

            return $position;

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Position
     * Put action
     * @var Request $request
     * @var Position $position
     * @return array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Edit a Position",
     *  input="KernelBundle\Form\PositionType",
     *  output="KernelBundle\Entity\Position",
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
     * @ParamConverter("position", class="KernelBundle:Position")
     * @Post("/position/{id}", requirements={"id" = "\d+"})
     */
    public function putPositionAction(Request $request, Position $position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $form = $this->createForm(
            new PositionType(),
            $position,
            ['roles' => $this->container->getParameter('security.role_hierarchy.roles')]
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($position);
            $em->flush();

            return $position;
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a Position
     * Delete action
     * @var Position $position
     * @return array
     *
     * @ApiDoc(
     *  section="Position",
     *  description="Delete a Position",
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
     * @ParamConverter("position", class="KernelBundle:Position")
     * @Delete("/position/{id}", requirements={"id" = "\d+"})
     */
    public function deletePositionAction(Position $position)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->remove($position);
        $em->flush();

        return array("status" => "Deleted");
    }

}
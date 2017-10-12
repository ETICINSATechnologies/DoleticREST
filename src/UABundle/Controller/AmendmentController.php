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
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\Amendment;
use UABundle\Entity\Project;
use UABundle\Form\AmendmentType;
use UABundle\Entity\AmendmentType as Type;

class AmendmentController extends FOSRestController
{

    /**
     * Get all the amendments
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get all amendments",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/amendments")
     */
    public function getAmendmentsAction()
    {

        $amendments = $this->getDoctrine()->getRepository("UABundle:Amendment")
            ->findAll();

        return array('amendments' => $amendments);
    }

    /**
     * Get all the amendments in a type
     * @param  Type $type
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get all amendments in a type",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("type", class="UABundle:AmendmentType")
     * @Get("/amendments/type/{id]", requirements={"id" = "\d+"})
     */
    public function getAmendmentsByTypeAction(Type $type)
    {

        $amendments = $this->getDoctrine()->getRepository("UABundle:Amendment")
            ->findByType($type);

        return array('amendments' => $amendments);
    }

    /**
     * Get all the amendments in a project
     * @param  Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get all amendments in a project",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/amendments/project/{id}", requirements={"id" = "\d+"})
     */
    public function getAmendmentsByProjectAction(Project $project)
    {

        $amendments = $this->getDoctrine()->getRepository("UABundle:Amendment")
            ->findBy(['project' => $project]);

        return array('amendments' => $amendments);
    }

    /**
     * Get a amendment by ID
     * @param Amendment $amendment
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Get a amendment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Get("/amendment/{id}", requirements={"id" = "\d+"})
     */
    public function getAmendmentAction(Amendment $amendment)
    {

        return array('amendment' => $amendment);

    }

    /**
     * Create a new Amendment
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Create a new Amendment",
     *  input="UABundle\Form\AmendmentType",
     *  output="UABundle\Entity\Amendment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @Post("/amendment")
     */
    public function postAmendmentAction(Request $request)
    {
        $amendment = new Amendment();
        $form = $this->createForm(new AmendmentType(), $amendment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $amendment->getProject())) {
                throw new AccessDeniedException();
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($amendment);
            $em->flush();

            return array("amendment" => $amendment);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a Amendment
     * Put action
     * @var Request $request
     * @var Amendment $amendment
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Edit a Amendment",
     *  input="UABundle\Form\AmendmentType",
     *  output="UABundle\Entity\Amendment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Post("/amendment/{id}", requirements={"id" = "\d+"})
     */
    public function putAmendmentAction(Request $request, Amendment $amendment)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $amendment->getProject())) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new AmendmentType(), $amendment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($amendment);
            $em->flush();

            return array("amendment" => $amendment);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete an Amendment
     * Delete action
     * @var Amendment $amendment
     * @return array
     *
     * @ApiDoc(
     *  section="Amendment",
     *  description="Delete an Amendment",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "admin" = "#e0a157"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("amendment", class="UABundle:Amendment")
     * @Delete("/amendment/{id}", requirements={"id" = "\d+"})
     */
    public function deleteAmendmentAction(Amendment $amendment)
    {
        if (!$this->get('ua.project.rights_service')->userHasRights($this->getUser(), $amendment->getProject())) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($amendment);
        $em->flush();

        return array("status" => "Deleted");
    }

}
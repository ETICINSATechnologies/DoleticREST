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
use UABundle\Entity\Project;
use UABundle\Entity\ProjectContact;
use UABundle\Form\ProjectContactType;

class ProjectContactController extends FOSRestController
{

    /**
     * Get all the project_contacts
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectContact",
     *  description="Get all project_contacts",
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
     * @Get("/project_contacts")
     */
    public function getProjectContactsAction()
    {

        $project_contacts = $this->getDoctrine()->getRepository("UABundle:ProjectContact")
            ->findAll();

        return array('project_contacts' => $project_contacts);
    }

    /**
     * Get all the project_contacts
     * @param Project $project
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectContact",
     *  description="Get all project_contacts",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Get("/project_contacts/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectContactsByProjectAction(Project $project)
    {

        $project_contacts = $this->getDoctrine()->getRepository("UABundle:ProjectContact")
            ->findBy(['project' => $project]);

        return array('project_contacts' => $project_contacts);
    }

    /**
     * Get a project_contact by ID
     * @param ProjectContact $project_contact
     * @return array
     *
     * @ApiDoc(
     *  section="ProjectContact",
     *  description="Get a project_contact",
     *  requirements={
     *      {
     *          "name"="project_contact",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="project_contact id"
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
     * @ParamConverter("project_contact", class="UABundle:ProjectContact")
     * @Get("/project_contact/{id}", requirements={"id" = "\d+"})
     */
    public function getProjectContactAction(ProjectContact $project_contact)
    {

        return array('project_contact' => $project_contact);

    }

    /**
     * Create a new ProjectContact
     * @var Request $request
     * @param Project $project
     * @return View|array
     *
     * @ApiDoc(
     *  section="ProjectContact",
     *  description="Create a new ProjectContact",
     *  input="UABundle\Form\ProjectContactType",
     *  output="UABundle\Entity\ProjectContact",
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
     * @ParamConverter("project", class="UABundle:Project")
     * @Post("/project_contact/{id}", requirements={"id" = "\d+"}))
     */
    public function postProjectContactAction(Request $request, Project $project)
    {
        $project_contact = new ProjectContact();
        $project_contact->setProject($project);
        $form = $this->createForm(new ProjectContactType(), $project_contact);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project_contact);
            $em->flush();

            return array("project_contact" => $project_contact);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete a ProjectContact
     * Delete action
     * @var ProjectContact $project_contact
     * @return array
     *
     * @View()
     * @ParamConverter("project_contact", class="UABundle:ProjectContact")
     * @Delete("/project_contact/{id}")
     */
    public function deleteProjectContactAction(ProjectContact $project_contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($project_contact);
        $em->flush();

        return array("status" => "Deleted");
    }

}
<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Form\PublishProjectDocumentType;

class UAController extends FOSRestController
{

    /**
     * Get current user rights
     * @return array
     *
     * @ApiDoc(
     *  section="UA",
     *  description="Get current user rights",
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
     * @Get("/rights")
     */
    public function getUARightsAction()
    {
        $role = 1;
        if ($this->isGranted('ROLE_UA_SUPERADMIN')) {
            $role = 4;
        } elseif ($this->isGranted('ROLE_UA_ADMIN')) {
            $role = 3;
        } elseif ($this->isGranted('ROLE_UA_USER')) {
            $role = 2;
        }
        return array('right' => $role);
    }

    /**
     * Publish a document template
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *  section="UA",
     *  description="Get current user rights",
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
     * @Post("/publish/project")
     */
    public function publishProjectDocumentAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_ADMIN');

        $form = $this->createForm(new PublishProjectDocumentType(), []);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $template = $form['template']->getData();
            $project = $form['project']->getData();
            $contact = $form['contact']->getData();
            $manager = $form['manager']->getData();
            $consultant = $form['consultant']->getData();
            $president = $this->getDoctrine()->getRepository('KernelBundle:User')->findPresident();
            $dict = $this->get('ua.document.service')->buildProjectDictionary($project, $manager, $contact, $consultant, $president);
            return $this->get('document_publisher')->publishFromTemplate($template, $dict, $project->getNumber());
        }

        return array(
            'form' => $form,
        );
    }

}
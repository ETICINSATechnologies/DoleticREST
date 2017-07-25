<?php

namespace UABundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KernelBundle\Entity\DocumentTemplate;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request;
use UABundle\Entity\StandardDocumentTemplate;
use UABundle\Form\StandardDocumentTemplateType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Debug\Exception\FatalThrowableError;



class StandardDocumentTemplateController extends FOSRestController
{

    /**
     * Get all the standard_document_templates
     * @return array
     *
     * @ApiDoc(
     *  section="StandardDocumentTemplate",
     *  description="Get all standard_document_templates",
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
     * @Get("/standard_document_templates")
     */
    public function getStandardDocumentTemplatesAction()
    {

        $standard_document_templates = $this->getDoctrine()->getRepository("UABundle:StandardDocumentTemplate")
            ->findAll();

        return array('standard_document_templates' => $standard_document_templates);
    }

    /**
     * Get a standard_document_template by ID
     * @param StandardDocumentTemplate $standard_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="StandardDocumentTemplate",
     *  description="Get a standard_document_template",
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
     * @ParamConverter("standard_document_template", class="UABundle:StandardDocumentTemplate")
     * @Get("/standard_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function getStandardDocumentTemplateAction(StandardDocumentTemplate $standard_document_template)
    {

        return array('standard_document_template' => $standard_document_template);

    }

    /**
     * Create a new StandardDocumentTemplate
     * @var Request $request
     * @return View|array
     *
     * @ApiDoc(
     *  section="StandardDocumentTemplate",
     *  description="Create a new StandardDocumentTemplate",
     *  input="UABundle\Form\StandardDocumentTemplateType",
     *  output="UABundle\Entity\StandardDocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @Post("/standard_document_template")
     */
    public function postStandardDocumentTemplateAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_UA_SUPERADMIN');

        $standard_document_template = new StandardDocumentTemplate();
        $form = $this->createForm(new StandardDocumentTemplateType(), $standard_document_template);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var UploadedFile $myFile */
            $myFile = $standard_document_template->getFile();
            if(!is_string($myFile)) { //Il y a un nouveau fichier
                $fileName = md5(uniqid()) . '.' . $myFile->guessExtension();
                $myFile->move($this->getParameter('templates_dir'), $fileName);
                $standard_document_template->setFile($fileName);
            }else{ //Il n'y a pas de nouveau fichier, on garde l'ancien
                $standard_document_template->setFile($myFile);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($standard_document_template);
            $em->flush();

            return array("standard_document_template" => $standard_document_template);

        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Edit a StandardDocumentTemplate
     * Put action
     * @var Request $request
     * @var StandardDocumentTemplate $standard_document_template
     * @return array
     *
     * @ApiDoc(
     *  section="StandardDocumentTemplate",
     *  description="Edit a StandardDocumentTemplate",
     *  input="UABundle\Form\StandardDocumentTemplateType",
     *  output="UABundle\Entity\StandardDocumentTemplate",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "ua" = "#0033ff",
     *   "super-admin" = "#da4932"
     *  }
     * )
     *
     * @View()
     * @ParamConverter("standard_document_template", class="UABundle:StandardDocumentTemplate")
     * @Post("/standard_document_template/{id}", requirements={"id" = "\d+"})
     */
    public function putStandardDocumentTemplateAction(Request $request, StandardDocumentTemplate $standard_document_template)
    {

        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        $form = $this->createForm(
            new StandardDocumentTemplateType(),
            $standard_document_template,
            ['mode' => StandardDocumentTemplateType::EDIT_MODE]
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($standard_document_template);
            $em->flush();

            return array("standard_document_template" => $standard_document_template);
        }

        return array(
            'form' => $form,
        );


    }

}
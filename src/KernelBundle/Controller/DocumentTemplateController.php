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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use KernelBundle\Entity\DocumentTemplate;
use KernelBundle\Form\DocumentTemplateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use UABundle\Entity\StandardDocumentTemplate;
use UABundle\Form\StandardDocumentTemplateType;

class DocumentTemplateController extends FOSRestController
{

    /**
     * Get all the templates
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get all templates",
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
     * @Get("/templates")
     */
    public function getDocumentTemplatesAction()
    {

        $templates = $this->getDoctrine()->getManager()->getRepository("KernelBundle:DocumentTemplate")
            ->findAll();

        return array('templates' => $templates);
    }

    /**
     * Get a template by ID
     * @param $id
     * @return array
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a template",
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
     * @Get("/template/{id}", requirements={"id" = "\d+"})
     */
    public function getDocumentTemplateAction($id)
    {
        file_put_contents("debug.txt", print_r("test\n", true));
        $templates = $this->getDoctrine()->getManager()->getRepository("KernelBundle:DocumentTemplate")
            ->findById($id);


        return array('templates' => $templates);
    }

    /**
     * Get a document template by ID
     * @param $id
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a documentTemplate",
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
     * @Get("/template/document/{id}", requirements={"id" = "\d+"})
     * @return Response
     */
    public function downloadDocumentTemplateAction($id)
    {
        /** @var DocumentTemplate $templates */
        $templates = $this->getDoctrine()->getManager()->getRepository("KernelBundle:DocumentTemplate")
            ->findBy(array('id' => $id))[$id];

        file_put_contents(__DIR__ . "/../../../debug.txt", print_r($templates, true));
        $path = $this->getParameter("templates_dir") . $templates->getFile();

        $response = new BinaryFileResponse($path);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;
    }


    /**
     * Get a template by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a template",
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
     * @Get("/template/{label}")
     */
    public function getDocumentTemplateByLabelAction($label)
    {

        $template = $this->getDoctrine()->getRepository('KernelBundle:DocumentTemplate')->findOneBy(['label' => $label]);
        return array('template' => $template);

    }

    /**
     * Delete a DocumentTemplate
     * Delete action
     * @var DocumentTemplate $template
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Delete a DocumentTemplate",
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
     * @ParamConverter("template", class="KernelBundle:DocumentTemplate")
     * @Delete("/template/{id}", requirements={"id" = "\d+"})
     */
    public function deleteDocumentTemplateAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        /** @var DocumentTemplate $template */
        $template = $this->getDoctrine()->getRepository('KernelBundle:DocumentTemplate')->find($id);
        $template->setDeprecated(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return array("status" => "Deleted");
    }

    /**
     * Get a template by label
     * @param string $label
     * @return array
     *
     * @ApiDoc(
     *  section="DocumentTemplate",
     *  description="Get a template",
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
     * @Get("/template/{label}")
     */
    public function putMasterDocumentTemplateAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_KERNEL_SUPERADMIN');

        /** @var DocumentTemplate $template */
        $template = $this->getDoctrine()->getRepository('KernelBundle:DocumentTemplate')->find($id);
        $template->setDeprecated(true);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return array("status" => "Deleted");
    }

}
















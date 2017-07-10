<?php

namespace DTBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends FOSRestController
{
    /**
     * Get all the current documents
     * @return array
     *
     * @ApiDoc(
     *  section="Document",
     *  description="Get all current document",
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
     * @Get("/document/current")
     */
    public function getCurrentDocumentsAction()
    {

        //$users = $this->getDoctrine()->getRepository("KernelBundle:Document")
        //    ->findUsersByOld(false);

        //return array('users' => $users);
    }
}

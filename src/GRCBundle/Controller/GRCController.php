<?php

namespace GRCBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class GRCController extends FOSRestController
{

    /**
     * Get current user rights
     * @return array
     *
     * @ApiDoc(
     *  section="GRC",
     *  description="Get current user rights",
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
     * @Get("/rights")
     */
    public function getGRCRightsAction()
    {
        $role = 1;
        if ($this->isGranted('ROLE_GRC_SUPERADMIN')) {
            $role = 4;
        } elseif ($this->isGranted('ROLE_GRC_ADMIN')) {
            $role = 3;
        } elseif ($this->isGranted('ROLE_GRC_USER')) {
            $role = 2;
        }
        return array('right' => $role);
    }

}
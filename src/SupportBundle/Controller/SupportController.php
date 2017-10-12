<?php

namespace SupportBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class SupportController extends FOSRestController
{

    /**
     * Get current user rights
     * @return array
     *
     * @ApiDoc(
     *  section="Support",
     *  description="Get current user rights",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "support" = "#0033ff",
     *   "guest" = "#85d893"
     *  }
     * )
     *
     * @View()
     * @Get("/rights")
     */
    public function getSupportRightsAction()
    {
        $role = 1;
        if ($this->isGranted('ROLE_SUPPORT_SUPERADMIN')) {
            $role = 4;
        } elseif ($this->isGranted('ROLE_SUPPORT_ADMIN')) {
            $role = 3;
        } elseif ($this->isGranted('ROLE_SUPPORT_USER')) {
            $role = 2;
        }
        return array('right' => $role);
    }

}
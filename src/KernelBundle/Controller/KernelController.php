<?php

namespace KernelBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class KernelController extends FOSRestController
{

    /**
     * Get current user rights
     * @return array
     *
     * @ApiDoc(
     *  section="Kernel",
     *  description="Get current user rights",
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
     * @Get("/rights")
     */
    public function getKernelRightsAction()
    {
        $role = 1;
        if ($this->isGranted('ROLE_KERNEL_SUPERADMIN')) {
            $role = 4;
        } elseif ($this->isGranted('ROLE_KERNEL_ADMIN')) {
            $role = 3;
        } elseif ($this->isGranted('ROLE_KERNEL_USER')) {
            $role = 2;
        }
        return array('right' => $role);
    }

}
<?php

namespace KernelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class KernelController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('KernelBundle:Default:index.html.twig');
    }
}

<?php

namespace Btn\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * The default admin panel view
     *
     * @Route("/", name="cp_homepage")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        return array();
    }
}

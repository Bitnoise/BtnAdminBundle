<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Entity\User;

/**
 * Movie controller.
 *
 * @Route("/control")
 */
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

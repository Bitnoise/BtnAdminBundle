<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Entity\User;

/**
 * @Route()
 */
class DefaultController extends Controller
{
    /**
     * The default admin panel view
     *
     * @Route("/", name="btn_admin_homepage")
     * @Route("/", name="btn_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}

<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route()
 */
class DefaultControlController extends Controller
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

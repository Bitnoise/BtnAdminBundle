<?php

namespace Btn\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultControlController extends Controller
{
    /**
     * @Route("/", name="btn_admin_defaultcontrol_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}

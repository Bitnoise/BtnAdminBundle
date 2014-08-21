<?php

namespace Btn\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Btn\AdminBundle\Annotation\Crud;

/**
 * @Route("/user")
 * @Crud()
 */
class UserControlController extends CrudController
{
}

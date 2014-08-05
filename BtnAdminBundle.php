<?php

namespace Btn\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BtnAdminBundle extends Bundle
{
    /**
     * @return string The Bundle parent name it overrides or null if no parent
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

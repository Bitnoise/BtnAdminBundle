<?php

namespace Btn\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Btn\AdminBundle\DependencyInjection\Compiler\MenuItemCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BtnAdminBundle extends Bundle
{
    /**
     * @param  ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MenuItemCompilerPass());
    }

    /**
     * @return string The Bundle parent name it overrides or null if no parent
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

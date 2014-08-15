<?php

namespace Btn\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Btn\AdminBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BtnAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\MenuBuilderCompilerPass());
        $container->addCompilerPass(new Compiler\AsseticCompilerPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

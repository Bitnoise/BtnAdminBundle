<?php

namespace Btn\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AsseticVoidCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('assetic.asset_factory')) {
            return;
        }

        // get files to viod from parameters
        $asseticVoidInputFiles = $container->getParameter('btn_admin.assetic.void_input_files');

        // if ther is nothig to viod then leve it as it is
        if (!$asseticVoidInputFiles) {
            return;
        }

        // Change asset factory to custom one with void functionality
        $container->setParameter('assetic.asset_factory.class', 'Btn\\AdminBundle\\Factory\\AssetFactory');

        // inject files to viod via method call injection
        $definition = $container->getDefinition('assetic.asset_factory');
        $definition->addMethodCall('setVoidInputFiles', array($asseticVoidInputFiles));
    }
}

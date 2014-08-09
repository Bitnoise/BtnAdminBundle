<?php

namespace Btn\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AsseticCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('assetic.asset_factory')) {
            return;
        }

        // get files to remove from assetc inputs
        $removeInputFiles  = $container->getParameter('btn_admin.assetic.remove_input_files');
        $replaceInputFiles = $container->getParameter('btn_admin.assetic.replace_input_files');
        $ensureCombine     = $container->getParameter('btn_admin.assetic.ensure_combine');

        // if ther is nothig to do then leve it as it is
        if (!$removeInputFiles && !$replaceInputFiles) {
            return;
        }

        // Change asset factory to custom one with remove/replace functionality
        $container->setParameter('assetic.asset_factory.class', 'Btn\\AdminBundle\\Factory\\AssetFactory');

        // inject files to viod via method call injection
        $definition = $container->getDefinition('assetic.asset_factory');
        $definition->addMethodCall('setRemoveInputFiles', array($removeInputFiles));
        $definition->addMethodCall('setReplaceInputFiles', array($replaceInputFiles));
        $definition->addMethodCall('setEnsureCombine', array($ensureCombine));
    }
}

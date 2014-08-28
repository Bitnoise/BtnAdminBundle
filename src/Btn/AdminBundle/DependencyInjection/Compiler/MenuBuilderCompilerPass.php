<?php

namespace Btn\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MenuBuilderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('btn_admin.menu_builder')) {
            return;
        }

        $menuItems = array();

        foreach ($container->findTaggedServiceIds('btn_admin.menu_item') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['parent'])) {
                    throw new \InvalidArgumentException(
                        sprintf('The parent is not defined in the "btn_admin.menu_item" tag for the service "%s"', $id)
                    );
                }
                $parent = $attributes['parent'];
                if (!isset($menuItems[$parent])) {
                    $menuItems[$parent] = array();
                }
                $menuItems[$parent][$id] = new Reference($id);
            }
        }

        foreach ($menuItems as $menuId => $children) {
            $definition = $container->getDefinition($menuId);
            $definition->replaceArgument(4, $children);
        }
    }
}

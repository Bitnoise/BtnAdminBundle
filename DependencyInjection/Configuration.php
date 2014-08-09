<?php

namespace Btn\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('btn_admin');

        $rootNode
            ->children()
                ->scalarNode('user_class')->cannotBeEmpty()->defaultValue('Btn\\AdminBundle\\Entity\\User')->end()
                ->scalarNode('user_table_name')->cannotBeEmpty()->defaultValue('btn_user')->end()
                ->scalarNode('app_name')->defaultValue('App')->end()
                ->scalarNode('app_year')->defaultValue('2014')->end()
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}

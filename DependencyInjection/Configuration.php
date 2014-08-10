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

                ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->cannotBeEmpty()->defaultValue(null)->info('Setup from fos_user by default')->end()
                    ->end()
                ->end()

                ->arrayNode('app')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultValue('AppName')->end()
                        ->scalarNode('year')->defaultValue('2014')->end()
                    ->end()
                ->end()

                ->arrayNode('menu')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('navbar')->defaultValue('btn_admin_menu_navbar')->end()
                    ->end()
                ->end()

                ->arrayNode('list')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('per_page')->cannotBeEmpty()->defaultValue(10)->end()
                    ->end()
                ->end()

                ->arrayNode('assetic')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('ensure_combine')->defaultValue(true)->end()
                        ->arrayNode('remove_input_files')
                            ->defaultValue(array())
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('replace_input_files')
                            ->defaultValue(array())
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}

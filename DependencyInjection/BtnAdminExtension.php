<?php

namespace Btn\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use FOS\UserBundle\DependencyInjection\Configuration as FOSUserConfiguration;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BtnAdminExtension extends Extension implements PrependExtensionInterface
{
    private $resourceDir = '/../Resources/config';

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('btn_admin', array());
        $container->setParameter('btn_admin.user.class', $config['user']['class']);
        $container->setParameter('btn_admin.app.name', $config['app']['name']);
        $container->setParameter('btn_admin.app.year', $config['app']['year']);
        $container->setParameter('btn_admin.menu.navbar', $config['menu']['navbar']);
        $container->setParameter('btn_admin.list.per_page', $config['list']['per_page']);
        $container->setParameter('btn_admin.assetic.remove_input_files', $config['assetic']['remove_input_files']);
        $container->setParameter('btn_admin.assetic.replace_input_files', $config['assetic']['replace_input_files']);
        $container->setParameter('btn_admin.assetic.ensure_combine', $config['assetic']['ensure_combine']);
        // $container->setParameter('btn_admin.assetic.base_css', $config['assetic']['base_css']);
        // $container->setParameter('btn_admin.assetic.base_js', $config['assetic']['base_js']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . $this->resourceDir));
        $loader->load('parameters.yml');
        $loader->load('services.yml');
        $loader->load('menus.yml');
        $loader->load('forms.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // Get loader to load more config files if needed
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . $this->resourceDir));

        // Get config for this extension
        $configs = $container->getExtensionConfig('btn_admin');

        // Process configuraton to gen normalized version
        $config = $this->getNormalizedConfig($container);

        // setup user_class from FOSUserBundle Configuration
        if ($container->hasExtension('fos_user')) {
            $fosUserConfigs       = $container->getExtensionConfig('fos_user');
            $fosUserConfiguration = new FOSUserConfiguration();
            $fosUserConfig        = $this->processConfiguration($fosUserConfiguration, $fosUserConfigs);

            // set up user class from fos if not set
            if (empty($config['user']['class'])) {
                $container->prependExtensionConfig('btn_admin', array(
                    'user' => array(
                        'class' => $fosUserConfig['user_class'],
                    ),
                ));
            }

            // refresh config after prepending
            $config = $this->getNormalizedConfig($container);
        }

        if ($container->hasExtension('knp_paginator')) {
            $container->prependExtensionConfig('knp_paginator', array(
                'template' => array(
                    'pagination' => 'BtnAdminBundle:Pagination:bootstrap.html.twig',
                    // 'sortable'   => 'BtnAdminBundle:Pagination:sortable_link.html.twig',
                ),
            ));
        }

        // add form resource and globals for twig
        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig('twig', array(
                'form' => array(
                    'resources' => array(
                        'BtnAdminBundle:Form:fields.html.twig',
                    )
                ),
                'globals' => array(
                    'btn_admin' => array(
                        'app' => array(
                            'name' => $config['app']['name'],
                            'year' => $config['app']['year'],
                        ),
                        'list' => array(
                            'per_page'   => $config['list']['per_page'],
                            'breadcrumb' =>$config['list']['breadcrumb'],
                        ),
                        'menu' => array(
                            'navbar' => $config['menu']['navbar'],
                        ),
                    ),
                )
            ));
        }

        // load assets for assetic
        if ($container->hasExtension('assetic')) {
            $loader->load('assetic.yml');

            $config = $this->getNormalizedConfig($container);
            // inject config for base assets from btn_admin to assetic config
            $container->prependExtensionConfig('assetic', array(
                'assets' => array(
                    'btn_admin_base_css' => $config['assetic']['base_css'],
                    'btn_admin_base_js' => $config['assetic']['base_js'],
                ),
            ));
        }
    }

    /**
     *
     */
    protected function getNormalizedConfig(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        return $config;
    }
}

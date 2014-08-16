<?php

namespace Btn\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Btn\BaseBundle\DependencyInjection\AbstractExtension;
use FOS\UserBundle\DependencyInjection\Configuration as FOSUserConfiguration;

/**
 *
 */
class BtnAdminExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);

        $config = $this->getProcessedConfig($container, $configs);

        $container->setParameter('btn_admin', array());
        $container->setParameter('btn_admin.user.class', $config['user']['class']);
        $container->setParameter('btn_admin.app.name', $config['app']['name']);
        $container->setParameter('btn_admin.app.year', $config['app']['year']);
        $container->setParameter('btn_admin.menu.navbar', $config['menu']['navbar']);
        $container->setParameter('btn_admin.list.per_page', $config['list']['per_page']);
        $container->setParameter('btn_admin.assetic.remove_input_files', $config['assetic']['remove_input_files']);
        $container->setParameter('btn_admin.assetic.replace_input_files', $config['assetic']['replace_input_files']);
        $container->setParameter('btn_admin.assetic.ensure_combine', $config['assetic']['ensure_combine']);
        $container->setParameter('btn_admin.assetic.skip_missing_assets', $config['assetic']['skip_missing_assets']);

        // override knp paginator class
        $container->setParameter('knp_paginator.class', 'Btn\\AdminBundle\\Pager\\Paginator');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        parent::prepend($container);

        // Get loader to load more config files if needed
        $loader = $this->getConfigLoader($container, __DIR__);

        // Process configuraton
        $config = $this->getProcessedConfig($container);

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
            $config = $this->getProcessedConfig($container);
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
                            'per_page'         => $config['list']['per_page'],
                            'date_format'      => $config['list']['date_format'],
                            'time_format'      => $config['list']['time_format'],
                            'date_time_format' => $config['list']['date_time_format'],
                        ),
                        'breadcrumb' => array(
                            'enabled' => $config['breadcrumb']['enabled'],
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
            $config = $this->getProcessedConfig($container);
            // inject config for base assets from btn_admin to assetic config
            $container->prependExtensionConfig('assetic', array(
                'assets' => array(
                    'btn_admin_base_css' => $config['assetic']['base_css'],
                    'btn_admin_base_js' => $config['assetic']['base_js'],
                ),
            ));
        }
    }
}

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
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('btn_admin', array());
        $container->setParameter('btn_admin.user_class', $config['user_class']);
        $container->setParameter('btn_admin.app_name', $config['app_name']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('forms.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // Get config for this extension
        $configs = $container->getExtensionConfig('btn_admin');

        // Process configuraton to gen normalized version
        $config = $this->getNormalizedConfig($container);

        // setup user_class from FOSUserBundle Configuration
        if ($container->hasExtension('fos_user')) {
            $fosUserConfigs       = $container->getExtensionConfig('fos_user');
            $fosUserConfiguration = new FOSUserConfiguration();
            $fosUserConfig        = $this->processConfiguration($fosUserConfiguration, $fosUserConfigs);

            $container->prependExtensionConfig('btn_admin', array(
                'user_class' => $fosUserConfig['user_class'],
            ));

            $config = $this->getNormalizedConfig($container);
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

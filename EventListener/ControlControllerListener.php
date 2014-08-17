<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Btn\BaseBundle\Helper\BundleHelper;
use Btn\AdminBundle\Controller\AbstractControlController;
use Btn\AdminBundle\Controller\AbstractCrudController;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;
use Doctrine\Common\Annotations\Reader;

class ControlControllerListener
{
    /** @var \Doctrine\Common\Annotations\Reader $annotationReader */
    protected $annotationReader;
    /** @var \Btn\BaseBundle\Helper\BundleHelper $bundleHelper */
    protected $bundleHelper;
    /** @var int $perPage */
    private $perPage;
    /** @var \Btn\AdminBundle\Form\Handler\FormHandlerInterface $formHandler */
    private $formHandler;

    /**
     *
     */
    public function __construct(Reader $annotationReader, BundleHelper $bundleHelper)
    {
        $this->annotationReader = $annotationReader;
        $this->bundleHelper     = $bundleHelper;
    }

    /**
     *
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;
    }

    /**
     *
     */
    public function setFormHandler(FormHandlerInterface $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    /**
     *
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        // handel AbstractControlController resolutions
        if ($controller[0] instanceof AbstractControlController) {
            if ($this->perPage) {
                $controller[0]->setPerPage($this->perPage);
            }
            if ($this->formHandler) {
                $controller[0]->setFormHandler($this->formHandler);
            }

            $entityProviderClass = 'Btn\\AdminBundle\\Annotation\\EntityProvider';
            $r = $this->bundleHelper->getReflectionClass($controller[0]);
            $entityProvider = $this->annotationReader->getClassAnnotation($r, $entityProviderClass);
            if ($entityProvider) {
                $controller[0]->setEntityProvider($entityProvider);
            }
        }

        // handel CrudSettings specific resolutions
        if ($controller[0] instanceof AbstractCrudController) {
            $crudSettingsClass = 'Btn\\AdminBundle\\Annotation\\CrudSettings';
            $r = $this->bundleHelper->getReflectionClass($controller[0]);
            $crudSettings = $this->annotationReader->getClassAnnotation($r, $crudSettingsClass);
            if ($crudSettings) {
                // if index template is not set then generate automaticly from controller
                if (null === $crudSettings->getIndexTemplate()) {
                    $templatePrefix = $this->bundleHelper->getTemplatePrefix($controller[0]);
                    $indexTemplate  = $templatePrefix . 'index.html.twig';
                    $crudSettings->setIndexTemplate($indexTemplate);
                }
                // if provider id is not set then generate automaticly from controller
                if (null === $crudSettings->getProviderId()) {
                    $providerId = $this->bundleHelper->getProviderId($controller[0]);
                    $crudSettings->setProviderId($providerId);
                }
                // if form id is not set then generate automaticly from controller
                if (null === $crudSettings->getFormAlias()) {
                    $formAlias = $this->bundleHelper->getFormAlias($controller[0]);
                    $crudSettings->setFormAlias($formAlias);
                }
                // if route prefix is not set then generate automaticly from controller
                if (null === $crudSettings->getRoutePrefix()) {
                    $routePrefix = $this->bundleHelper->getRoutePrefix($controller[0]);
                    $crudSettings->setRoutePrefix($routePrefix);
                }

                $controller[0]->setCrudSettings($crudSettings);
            }
        }
    }

}

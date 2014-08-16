<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Btn\AdminBundle\Controller\AbstractControlController;
use Btn\AdminBundle\Controller\AbstractCrudController;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;
use Doctrine\Common\Annotations\Reader;

class ControlControllerListener
{
    /** @var \ReflectionClass[] $reflectionClasses of \Btn\AdminBundle\Controller\AbstractControlController */
    protected $reflectionClasses = array();
    /** @var \Doctrine\Common\Annotations\Reader $annotationReader */
    protected $annotationReader;
    /** @var \Doctrine\Common\Annotations\Reader $annotationReader */
    protected $container;
    /** @var int $perPage */
    private $perPage;
    /** @var \Btn\AdminBundle\Form\Handler\FormHandlerInterface $formHandler */
    private $formHandler;

    /**
     *
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
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
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

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
            $r = $this->getReflectionClass($controller[0]);
            $entityProvider = $this->annotationReader->getClassAnnotation($r, $entityProviderClass);
            if ($entityProvider) {
                $controller[0]->setEntityProvider($entityProvider);
            }
        }

        // handel CrudSettings specific resolutions
        if ($controller[0] instanceof AbstractCrudController) {
            $crudSettingsClass = 'Btn\\AdminBundle\\Annotation\\CrudSettings';
            $r = $this->getReflectionClass($controller[0]);
            $crudSettings = $this->annotationReader->getClassAnnotation($r, $crudSettingsClass);
            if ($crudSettings) {
                // if index template is not set then generate automaticly from controller
                if (null === $crudSettings->getIndexTemplate()) {
                    $bundleName     = $this->getBundleName($controller[0]);
                    $controllerName = $this->getControllerName($controller[0]);
                    $indexTemplate  = $bundleName . ':' . $controllerName . ':' . 'index.html.twig';
                    $crudSettings->setIndexTemplate($indexTemplate);
                }

                $controller[0]->setCrudSettings($crudSettings);
            }
        }
    }

    /**
     *
     */
    protected function getReflectionClass(AbstractControlController $controller)
    {
        $hash = spl_object_hash($controller);
        if (!isset($this->reflectionClasses[$hash])) {
            $this->reflectionClass[$hash] = new \ReflectionClass($controller);
        }

        return $this->reflectionClass[$hash];
    }

    /**
     *
     */
    protected function getBundleName(AbstractControlController $controller)
    {
        $r  = $this->getReflectionClass($controller);
        $ns = $r->getNamespaceName();

        if (preg_match(('~[A-Za-z\\\\0-9]+Bundle~'), $ns, $matches)) {
            return str_replace('\\', '', $matches[0]);
        }

        throw new \Exception(sprintf('Could not get bundle name from "%s"', $ns));
    }

    /**
     *
     */
    protected function getControllerName(AbstractControlController $controller)
    {
        $r  = $this->getReflectionClass($controller);
        $cn = $r->getShortName();

        if (preg_match(('~([A-Za-z0-9]+)Controller~'), $cn, $matches)) {
            return $matches[1];
        }

        throw new \Exception(sprintf('Could not get controller name from "%s"', $className));
    }
}

<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Btn\AdminBundle\Controller\AbstractControlController;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Btn\AdminBundle\Annotation\EntityProvider;

class ControlControllerListener
{
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
    public function __construct(/*ContainerInterface $container,*/ $annotationReader)
    {
        $this->annotationReader = $annotationReader;
        // $this->container = $container;
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

        if ($controller[0] instanceof AbstractControlController) {
            if ($this->perPage) {
                $controller[0]->setPerPage($this->perPage);
            }
            if ($this->formHandler) {
                $controller[0]->setFormHandler($this->formHandler);
            }

            $entityProviderClass = 'Btn\\AdminBundle\\Annotation\\EntityProvider';
            $refClass = new \ReflectionClass($controller[0]);
            $entityProvider = $this->annotationReader->getClassAnnotation($refClass, $entityProviderClass);
            if ($entityProvider) {
                $controller[0]->setEntityProvider($entityProvider);
            }
        }
    }
}

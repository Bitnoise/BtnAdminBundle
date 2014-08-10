<?php

namespace Btn\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Btn\AdminBundle\Controller\AbstractControlController;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;

class ControlControllerListener
{
    /** @var int $perPage */
    private $perPage;

    /** @var */
    private $formHandler;

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

        if ($controller[0] instanceof AbstractControlController) {
           if ($this->perPage) {
               $controller[0]->setPerPage($this->perPage);
           }
           if ($this->formHandler) {
               $controller[0]->setFormHandler($this->formHandler);
           }
        }
    }
}

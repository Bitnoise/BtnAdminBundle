<?php

namespace Btn\AdminBundle\Controller;

use Btn\BaseBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;

class AbstractControlController extends AbstractController
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
    protected function getPerPage()
    {
        return $this->perPage;
    }

    /**
     *
     */
    protected function handleForm(FormInterface $form, Request $request)
    {
        $this->formHandler->handleForm($form, $request);
    }
}

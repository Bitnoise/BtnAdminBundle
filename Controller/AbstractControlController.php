<?php

namespace Btn\AdminBundle\Controller;

use Btn\BaseBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;
use Btn\AdminBundle\Annotation\EntityProvider;

class AbstractControlController extends AbstractController
{
    /** @var int $perPage */
    private $perPage;

    /** @var \Btn\AdminBundle\Form\Handler\FormHandlerInterface $formHandler */
    private $formHandler;

    /** @var \Btn\AdminBundle\Annotation\EntityProvider $entityProvider */
    private $entityProvider;

    /**
     *
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    /**
     *
     */
    public function setFormHandler(FormHandlerInterface $formHandler)
    {
        $this->formHandler = $formHandler;

        return $this;
    }

    /**
     *
     */
    public function setEntityProvider(EntityProvider $entityProvider)
    {
        $this->entityProvider = $entityProvider;

        return $this;
    }

    /**
     *
     */
    public function getEntityProvider()
    {
        if (!$this->entityProvider || !$this->entityProvider instanceof EntityProvider) {
            throw new \Exception('Entity provider is missing from controller');
        }

        $entityProviderServiceId = $this->entityProvider->getServiceId();

        return $this->get($entityProviderServiceId);
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
        if (!$this->formHandler || !$this->formHandler instanceof FormHandlerInterface) {
            throw new \Exception('Form handler is missing from controller');
        }

        $this->formHandler->handle($form, $request);
    }
}

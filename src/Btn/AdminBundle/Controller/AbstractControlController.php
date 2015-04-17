<?php

namespace Btn\AdminBundle\Controller;

use Btn\BaseBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Btn\AdminBundle\Form\Handler\FormHandlerInterface;
use Btn\AdminBundle\Annotation\EntityProvider;
use Btn\BaseBundle\Filter\FilterInterface;

class AbstractControlController extends AbstractController
{
    /** @var int $perPage */
    protected $perPage;

    /** @var \Btn\AdminBundle\Form\Handler\FormHandlerInterface $formHandler */
    protected $formHandler;

    /** @var \Btn\AdminBundle\Annotation\EntityProvider $entityProvider */
    protected $entityProvider;

    /** @var \Btn\BaseBundle\Filter\FilterInterface $filter */
    protected $filter;

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
            throw new \Exception('Entity provider is missing in controller');
        }

        $entityProviderId = $this->entityProvider->getProviderId();

        if (!$entityProviderId) {
            throw new \Exception('Entity provider id is missing in controller');
        }

        return $this->get($entityProviderId);
    }

    /**
     *
     */
    public function hasFilter()
    {
        return $this->filter ? true : false;
    }

    /**
     *
     */
    public function setFilter(FilterInterface $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     *
     */
    public function getFilter()
    {
        if (!$this->filter) {
            throw new \Exception('Filter is missing in controller');
        }

        return $this->filter;
    }

    /**
     *
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     *
     */
    public function handleForm(FormInterface $form, Request $request)
    {
        if (!$this->formHandler || !$this->formHandler instanceof FormHandlerInterface) {
            throw new \Exception(sprintf('Form handler was not injected to "%s"', __CLASS__));
        }

        return $this->formHandler->handle($form, $request);
    }

    /**
     *
     */
    public function paginate($target, $page = null, $limit = null, array $options = null)
    {
        $paginator = $this->get('knp_paginator');

        if (null === $page) {
            $pageParameterName = $paginator->getDefaultOption('pageParameterName');
            $page = $this->get('request_stack')->getCurrentRequest()->query->getInt($pageParameterName, 1);
        }

        if (null === $limit) {
            $limit = $this->getPerPage();
        }

        if (null === $options) {
            $options = array();
        }

        return $paginator->paginate($target, $page, $limit, $options);
    }
}

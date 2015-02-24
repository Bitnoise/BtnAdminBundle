<?php

namespace Btn\AdminBundle\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class CrudSettings extends EntityProvider
{
    /** @var string $form form alias for create/update actions */
    protected $formAlias      = null;
    /** @var string $formHandlerId form handler service id */
    protected $formHandlerId  = 'btn_admin.form.handler.entity_form';
    /** @var string $filterId if of service that should handle list filtering */
    protected $filterId       = null;
    /** @var string $routePrefix route prefix to generate index/create/update routes */
    protected $routePrefix    = null;
    /** @var string $indexTemplate */
    protected $indexTemplate  = null;
    /** @var string $createTemplate */
    protected $createTemplate = 'BtnAdminBundle:Crud:create.html.twig';
    /** @var string $editTemplate */
    protected $updateTemplate = 'BtnAdminBundle:Crud:update.html.twig';

    /**
     *
     */
    public function setFormAlias($formAlias)
    {
        $this->formAlias = $formAlias;

        return $this;
    }

    /**
     *
     */
    public function getFormAlias()
    {
        return $this->formAlias;
    }

    /**
     *
     */
    public function setFormHandlerId($formHandlerId)
    {
        $this->formHandlerId = $formHandlerId;

        return $this;
    }

    /**
     *
     */
    public function getFormHandlerId()
    {
        return $this->formHandlerId;
    }

    /**
     *
     */
    public function setFilterId($filterId)
    {
        $this->filterId = $filterId;
    }

    /**
     *
     */
    public function getFilterId()
    {
        return $this->filterId;
    }

    /**
     *
     */
    public function setRoutePrefix($routePrefix)
    {
        $this->routePrefix = $routePrefix;

        return $this;
    }

    /**
     *
     */
    public function getRoutePrefix()
    {
        return $this->routePrefix;
    }

    /**
     *
     */
    public function setIndexTemplate($indexTemplate)
    {
        $this->indexTemplate = $indexTemplate;
    }

    /**
     *
     */
    public function getIndexTemplate()
    {
        return $this->indexTemplate;
    }

    /**
     *
     */
    public function getCreateTemplate()
    {
        return $this->createTemplate;
    }

    /**
     *
     */
    public function getUpdateTemplate()
    {
        return $this->updateTemplate;
    }
}

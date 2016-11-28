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
    protected $formName       = null;
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
     * @param string
     *
     * @return CrudSettings
     */
    public function setFormAlias($formAlias)
    {
        $this->formAlias = $formAlias;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormAlias()
    {
        return $this->formAlias;
    }

    /**
     * @return null|string
     */
    public function getFormName()
    {
        return $this->formName ? $this->formName : $this->getFormAlias();
    }

    /**
     * @param $formName
     */
    public function setFormName($formName)
    {
        $this->formName = $formName;
    }

    /**
     * @param string
     *
     * @return CrudSettings
     */
    public function setFormHandlerId($formHandlerId)
    {
        $this->formHandlerId = $formHandlerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormHandlerId()
    {
        return $this->formHandlerId;
    }

    /**
     * @param string
     */
    public function setFilterId($filterId)
    {
        $this->filterId = $filterId;
    }

    /**
     * @return string
     */
    public function getFilterId()
    {
        return $this->filterId;
    }

    /**
     * @param string
     *
     * @return CrudSettings
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
     * @return string
     */
    public function getIndexTemplate()
    {
        return $this->indexTemplate;
    }

    /**
     * @return string
     */
    public function getCreateTemplate()
    {
        return $this->createTemplate;
    }

    /**
     * @return string
     */
    public function getUpdateTemplate()
    {
        return $this->updateTemplate;
    }
}

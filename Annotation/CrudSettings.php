<?php

namespace Btn\AdminBundle\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class CrudSettings extends EntityProvider
{
    /** @var string $form form alias for new/create/update actions */
    protected $formId;
    /** @var string $indexTemplate */
    protected $indexTemplate  = null;
    /** @var string $createTemplate */
    protected $createTemplate = 'BtnAdminBundle:BaseCrud:create.html.twig';
    /** @var string $editTemplate */
    protected $updateTemplate = 'BtnAdminBundle:BaseCrud:update.html.twig';

    /**
     *
     */
    public function getFormId()
    {
        return $this->formId;
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

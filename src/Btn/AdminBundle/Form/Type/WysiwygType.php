<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WysiwygType extends AbstractType
{
    /** @var string $filebrowserRoute */
    protected $filebrowserRoute;

    /**
     *
     */
    public function setFilebrowserRoute($filebrowserRoute)
    {
        $this->filebrowserRoute = $filebrowserRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        if ($this->filebrowserRoute) {
            $resolver->setDefaults(array(
                'config' => array(
                    'filebrowserBrowseRoute' => $this->filebrowserRoute,
                ),
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => CKEditorType::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'ckeditor';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_wysiwyg';
    }
}

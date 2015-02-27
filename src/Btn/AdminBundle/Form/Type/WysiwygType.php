<?php

namespace Btn\AdminBundle\Form\Type;

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
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

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

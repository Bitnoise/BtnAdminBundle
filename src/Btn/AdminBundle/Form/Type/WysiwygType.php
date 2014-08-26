<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WysiwygType extends AbstractType
{
    /** @var string $filebrowserBrowseRoute */
    protected $filebrowserBrowseRoute;

    /**
     *
     */
    public function setFilebrowserBrowseRoute($filebrowserBrowseRoute)
    {
        $this->filebrowserBrowseRoute = $filebrowserBrowseRoute;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        if ($this->filebrowserBrowseRoute) {
            $resolver->setDefaults(array(
                'config' => array(
                    'filebrowserBrowseRoute' => $this->filebrowserBrowseRoute,
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

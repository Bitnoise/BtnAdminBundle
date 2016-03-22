<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class VimeoThumbnailSizeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'required' => false,
            'searchable' => false,
            'multiple' => false,
            'label' => 'btn_admin.vimeo_thumbnail_size',
            'placeholder' => 'btn_admin.vimeo_thumbnail_size.placeholder',
            'choices' => array(
                'thumbnail_small' => 'btn_admin.vimeo_thumbnail_size.thumbnail_small',
                'thumbnail_medium' => 'btn_admin.vimeo_thumbnail_size.thumbnail_medium',
                'thumbnail_large' => 'btn_admin.vimeo_thumbnail_size.thumbnail_large',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'btn_select2_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_vimeo_thumbnail_size';
    }
}

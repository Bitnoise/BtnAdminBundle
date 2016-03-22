<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class YoutubeThumbnailSizeType extends AbstractType
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
            'label' => 'btn_admin.youtube_thumbnail_size',
            'placeholder' => 'btn_admin.youtube_thumbnail_size.placeholder',
            'choices' => array(
                'default' => 'btn_admin.youtube_thumbnail_size.default',
                'hqdefault' => 'btn_admin.youtube_thumbnail_size.hqdefault',
                'mqdefault' => 'btn_admin.youtube_thumbnail_size.mqdefault',
                'sddefault' => 'btn_admin.youtube_thumbnail_size.sddefault',
                'maxresdefault' => 'btn_admin.youtube_thumbnail_size.maxresdefault',
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
        return 'btn_youtube_thumbnail_size';
    }
}

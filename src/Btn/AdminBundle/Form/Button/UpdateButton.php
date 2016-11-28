<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateButton extends AbstractButton
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'label' => 'btn_admin.update',
            'attr'  => array(
                'class' => 'btn btn-success btn-update',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_update';
    }
}

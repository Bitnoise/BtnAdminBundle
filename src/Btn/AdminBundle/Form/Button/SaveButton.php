<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SaveButton extends AbstractButton
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'label' => 'btn_admin.save',
            'attr'  => array(
                'class' => 'btn btn-success btn-save',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_save';
    }
}

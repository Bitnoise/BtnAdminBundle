<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateButton extends AbstractButton
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'label' => 'btn_admin.create',
            'attr'  => array(
                'class' => 'btn btn-success btn-create',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_create';
    }
}

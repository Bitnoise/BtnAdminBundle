<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterButton extends AbstractButton
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'label' => 'btn_admin.filter',
            'attr'  => array(
                'class' => 'btn btn-info btn-filter',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_filter';
    }
}

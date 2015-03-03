<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class HrType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'mapped'   => false,
            'required' => false,
            'label'    => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_hr';
    }
}

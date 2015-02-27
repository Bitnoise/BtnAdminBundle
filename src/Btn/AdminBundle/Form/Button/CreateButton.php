<?php

namespace Btn\AdminBundle\Form\Button;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
class CreateButton extends AbstractType implements SubmitButtonTypeInterface
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
    public function getParent()
    {
        return 'submit';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_create';
    }
}

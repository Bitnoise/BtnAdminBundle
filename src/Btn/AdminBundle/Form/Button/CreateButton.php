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
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

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

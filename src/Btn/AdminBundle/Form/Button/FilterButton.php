<?php

namespace Btn\AdminBundle\Form\Button;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 */
class FilterButton extends AbstractType implements SubmitButtonTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

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
    public function getParent()
    {
        return 'submit';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_filter';
    }
}

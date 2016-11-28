<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeleteButton extends AbstractButton
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'label' => 'btn_admin.delete',
            'attr'  => array(
                'class'        => 'btn btn-danger btn-delete',
                'data-confirm' => $this->translator->trans('btn_admin.confirm_delete'),
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_delete';
    }
}

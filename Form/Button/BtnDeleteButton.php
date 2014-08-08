<?php

namespace Btn\AdminBundle\Form\Button;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 *
 */
class BtnDeleteButton extends AbstractType implements SubmitButtonTypeInterface
{
    /** @var \Symfony\Component\Translation\TranslatorInterface $translator */
    protected $translator;

    /**
     *
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => 'btn_admin.delete',
            'attr'  => array(
                'class'        => 'btn btn-danger',
                'data-confirm' => $this->translator->trans('btn_admin.confirm_delete'),
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
        return 'btn_admin_delete_button';
    }
}

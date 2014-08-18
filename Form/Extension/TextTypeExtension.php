<?php

namespace Btn\AdminBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['addon_pre'] = isset($options['addon_pre']) ? $options['addon_pre'] : null;
        $view->vars['addon_post'] = isset($options['addon_post']) ? $options['addon_post'] : null;
        $view->vars['addon'] = (!empty($options['addon_pre']) || !empty($options['addon_post'])) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'addon_pre'  => null,
            'addon_post' => null,
        ));

        $resolver->setOptional(array(
            'addon_pre',
            'addon_post',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'text';
    }
}

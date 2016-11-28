<?php

namespace Btn\AdminBundle\Form\Extension;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TextTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['addon_prepend'] = isset($options['addon_prepend']) ? $options['addon_prepend'] : null;
        $view->vars['addon_append'] = isset($options['addon_append']) ? $options['addon_append'] : null;
        $view->vars['addon'] = (!empty($options['addon_prepend']) || !empty($options['addon_append'])) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'addon_prepend'  => null,
            'addon_append' => null,
        ));

        $resolver->setDefined(array(
            'addon_prepend',
            'addon_append',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return Form::getFormName(array(
            'alias' => 'text',
            'class' => TextType::class,
        ));
    }
}

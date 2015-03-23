<?php

namespace Btn\AdminBundle\Form\Extension;

use Btn\BaseBundle\Form\Type\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($options['has_conditional_rows']) {
            $this->assetLoader->load('btn_admin_conditional_row_js');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'has_conditional_rows',
            'conditional_row_name',
            'conditional_row_value',
        ));

        $resolver->setDefaults(array(
            'has_conditional_rows'  => false,
            'conditional_row_name'  => null,
            'conditional_row_value' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (true === $options['has_conditional_rows']) {
            $view->vars['has_conditional_rows']  = $view->vars['name'];
        } else {
            $view->vars['has_conditional_rows']  = $options['has_conditional_rows'];
        }

        if ($view->vars['has_conditional_rows']) {
            $view->vars['attr']['btn-has-conditional-rows'] = $view->vars['has_conditional_rows'];
        } elseif (($view->parent && $view->parent->vars['has_conditional_rows'])) {
            $view->vars['attr']['btn-has-conditional-rows'] = $view->parent->vars['has_conditional_rows'];
        }

        $view->vars['conditional_row_name']  = $options['conditional_row_name'];
        $view->vars['conditional_row_value'] = $options['conditional_row_value'];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'form';
    }
}

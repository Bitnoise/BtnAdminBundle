<?php

namespace Btn\AdminBundle\Form;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($options['loading']) {
            $this->assetLoader->load('btn_admin_loading');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (!$form->getParent() && !$view->parent) {
            $view->vars['fieldset'] = $options['fieldset'];
            $view->vars['legend']   = $options['legend'];
            $view->vars['attr']['novalidate'] = 'novalidate';
            if (!isset($view->vars['attr']['class'])) {
                $view->vars['attr']['class'] = '';
            }
            $view->vars['attr']['class'] .= ' form-horizontal';
            $view->vars['attr']['class'] = trim($view->vars['attr']['class']);

            if ($options['role']) {
                $view->vars['attr']['role'] = $options['role'];
            }

            if ($options['loading']) {
                $view->vars['attr']['data-loading'] = $options['loading'];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'fieldset' => true,
            'legend'   => false,
            'role'     => 'form',
            'loading'  => true,
        ));

        $resolver->setOptional(array(
            'fieldset',
            'legend',
            'role',
            'loading',
        ));
    }
}

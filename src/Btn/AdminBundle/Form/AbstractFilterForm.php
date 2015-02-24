<?php

namespace Btn\AdminBundle\Form;

use Btn\BaseBundle\Form\AbstractFilterForm as BaseAbstractFilterForm;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Btn\AdminBundle\Form\EventListener\AddFilterButtonSubscriber;

class AbstractFilterForm extends BaseAbstractFilterForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventSubscriber(new AddFilterButtonSubscriber());
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (!$form->getParent() && !$view->parent) {
            $view->vars['attr']['novalidate'] = 'novalidate';
            if (!isset($view->vars['attr']['class'])) {
                $view->vars['attr']['class'] = '';
            }
            $view->vars['attr']['class'] .= ' form-inline';
            $view->vars['inline'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter';
    }
}

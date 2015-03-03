<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

class TimeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if (!empty($options['format']) && 'string' === $options['input']) {
            $builder->resetModelTransformers();
            $builder->addModelTransformer(
                new ReversedTransformer(new DateTimeToStringTransformer(null, null, $options['format']))
            );
            $builder->resetViewTransformers();
            $builder->addViewTransformer(
                new DateTimeToStringTransformer(null, null, $options['format'])
            );
        }

        $this->assetLoader->load(array('btn_admin_datetimepicker'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setOptional(array(
            'autoclose',
            'meridian',
        ));

        $resolver->setAllowedTypes('autoclose', array('bool'));
        $resolver->setAllowedTypes('meridian', array('bool'));

        $resolver->setDefaults(array(
            'widget'      => 'single_text',
            'format'      => 'HH:mm:ss',
            'time_format' => 'hh:ii:ss',
            'autoclose'   => true,
            'meridian'    => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-datetimepicker'] = true;
        $view->vars['attr']['data-date-format']   = $options['time_format'];
        $view->vars['attr']['data-start-view']    = 'hour';
        $view->vars['attr']['data-min-view']      = 'hour';
        $view->vars['attr']['data-max-view']      = 'hour';
        $view->vars['attr']['data-view-select']   = 'hour';

        $view->vars['attr']['data-show-meridian'] = $options['meridian'];

        if (isset($options['autoclose'])) {
            $view->vars['attr']['data-date-autoclose'] = $options['autoclose'];
        }

        if (!isset($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] = '';
        }

        $view->vars['attr']['class'] = trim($view->vars['attr']['class'].' btn-time btn-datetimepicker');

        if ('single_text' === $options['widget']) {
            $view->vars['type'] = 'text';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'time';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_time';
    }
}

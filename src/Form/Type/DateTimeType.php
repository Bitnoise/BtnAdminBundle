<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateTimeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load(array('btn_admin_datetimepicker'));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'autoclose',
        ));

        $resolver->setAllowedTypes(array(
            'autoclose' => array('bool'),
        ));

        $resolver->setDefaults(array(
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd HH:mm:ss',
            'autoclose' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-datetimepicker']  = true;
        $view->vars['attr']['data-date-format']    = 'yyyy-mm-dd hh:ii:ss';

        if (isset($options['autoclose'])) {
            $view->vars['attr']['data-date-autoclose'] = $options['autoclose'];
        }

        if (!isset($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] = '';
        }

        $view->vars['attr']['class'] = trim($view->vars['attr']['class'] . ' btn-datetime btn-datetimepicker');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_datetime';
    }
}

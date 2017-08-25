<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'autoclose',
        ));

        $resolver->setAllowedTypes('autoclose', array('bool'));

        $resolver->setDefaults(array(
            'widget'      => 'single_text',
            'format'      => 'yyyy-MM-dd HH:mm:ss',
            'date_format' => 'yyyy-mm-dd hh:ii:ss',
            'autoclose'   => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-datetimepicker']  = true;
        $view->vars['attr']['data-date-format']    = $options['date_format'];

        if (isset($options['autoclose'])) {
            $view->vars['attr']['data-date-autoclose'] = $options['autoclose'];
        }

        if (!isset($view->vars['attr']['class'])) {
            $view->vars['attr']['class'] = '';
        }

        $view->vars['attr']['class'] = trim($view->vars['attr']['class'].' btn-datetime btn-datetimepicker');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'datetime';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_datetime';
    }
}

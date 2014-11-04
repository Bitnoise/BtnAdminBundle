<?php

namespace Btn\AdminBundle\Form\Extension;

use Btn\BaseBundle\Form\Type\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['inline'] = (!empty($options['inline']) || !empty($options['inline'])) ? true : false;
        if (isset($options['ajax-reload'])) {
            $this->assetLoader->load(array('btn_admin_loading', 'btn_admin_ajax_reload'));
            $view->vars['attr']['btn-ajax-reload'] = is_string($options['ajax-reload']) ? $options['ajax-reload'] : null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'inline' => null,
        ));

        $resolver->setOptional(array(
            'inline',
            'ajax-reload',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'choice';
    }
}

<?php

namespace Btn\AdminBundle\Form\Extension;

use Btn\BaseBundle\Form\Type\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $opt = & $options;

        $view->vars['inline'] = (!empty($opt['inline']) || !empty($opt['inline'])) ? true : false;
        if (isset($opt['ajax_reload'])) {
            $this->assetLoader->load(array('btn_admin_loading', 'btn_admin_ajax_reload'));
            $view->vars['attr']['btn-ajax-reload'] = is_string($opt['ajax_reload']) ? $opt['ajax_reload'] : null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'inline' => null,
        ));

        $resolver->setOptional(array(
            'inline',
            'ajax_reload',
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

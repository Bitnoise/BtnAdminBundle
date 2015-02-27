<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmbeddedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load('btn_admin_embedded_js');

        if ($options['sortable']) {
            $this->assetLoader->load('btn_admin_jquery_ui');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        // aliases
        $attr = & $view->vars['attr'];
        $opt  = & $options;

        $attr['data-prototype-replacement'] = $opt['prototype_name'];
        if ($opt['allow_add'] && $opt['prototype_add']) {
            $attr['data-prototype-add'] = '<button type="button" class="btn btn-success btn-sm btn-add">'
                .$this->trans($opt['prototype_add']).'</button>';
        }
        if ($opt['allow_delete'] && $opt['prototype_remove']) {
            $attr['data-prototype-remove'] = ''
                .'<button type="button" btn-remove="true" class="btn btn-danger btn-sm btn-remove">'
                .$this->trans($opt['prototype_remove'])
                .'</button>';
        }
        if ($opt['allow_add'] && $opt['prototype_limit']) {
            $attr['data-prototype-limit'] = $opt['prototype_limit'];
        }
        if ($opt['sortable']) {
            $attr['data-sortable'] = $opt['sortable'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'prototype_add',
            'prototype_remove',
            'prototype_limit',
            'sortable',
        ));

        $resolver->setDefaults(array(
            'prototype_add'    => 'btn_admin.form.type.embeded.add',
            'prototype_remove' => 'btn_admin.form.type.ebmeded.remove',
            'prototype_limit'  => null,
            'sortable'         => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_embedded';
    }
}

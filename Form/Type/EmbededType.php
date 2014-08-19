<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmbededType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load('btn_admin_embeded_js');

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
        $a =& $view->vars['attr'];
        $o =& $options;

        $a['data-prototype-replacement'] = $o['prototype_name'];
        if ($o['allow_add'] && $o['prototype_add']) {
            $a['data-prototype-add'] = '<button type="button" class="btn btn-success btn-sm btn-add">'
                . $this->trans($o['prototype_add']) . '</button>';
        }
        if ($o['allow_delete'] && $o['prototype_remove']) {
            $a['data-prototype-remove'] = '<button type="button" data-btn-remove="true" class="btn btn-danger btn-sm btn-remove">'
                . $this->trans($o['prototype_remove'])
                . '</button>';
        }
        if ($o['allow_add'] && $o['prototype_limit']) {
            $a['data-prototype-limit'] = $o['prototype_limit'];
        }
        if ($o['sortable']) {
            $a['data-sortable'] = $o['sortable'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
        return 'btn_embeded';
    }
}

<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class Select2Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load('btn_admin_select2');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'searchable',
        ));

        $resolver->setAllowedTypes('searchable', array('bool', 'integer'));

        $resolver->setDefaults(array(
            'searchable' => true,
        ));
    }

    abstract public function getAlias();

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-select2'] = null;
        $view->vars['attr']['btn-select2-'.$this->getAlias()] = null;

        if (false === $options['searchable']) {
            $view->vars['attr']['btn-select2-minimum-results-for-search'] = '-1';
        } elseif (is_int($options['searchable'])) {
            $view->vars['attr']['btn-select2-minimum-results-for-search'] = $options['searchable'];
        }
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_select2_'.$this->getAlias();
    }
}

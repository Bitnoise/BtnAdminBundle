<?php

namespace Btn\AdminBundle\Form;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Btn\AdminBundle\Form\EventListener\AddSaveButtonSubscriber;

abstract class AbstractForm extends AbstractType
{
    /** @var bool $addSaveButtonSubscriber */
    private $addSaveButtonSubscriber = true;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        if ($this->addSaveButtonSubscriber) {
            $builder->addEventSubscriber(new AddSaveButtonSubscriber());
        }

        if ($options['loading']) {
            if ($this->assetLoader) {
                $this->assetLoader->load('btn_admin_loading');
            } else {
                throw new \Exception(sprintf(
                    'Asset loader is missing in "%s". '
                    .'Extend @btn_admin.form.abstract service or inject it via setAssetLoader()',
                    __CLASS__
                ));
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        if (!$form->getParent() && !$view->parent) {
            $view->vars['fieldset'] = isset($options['fieldset']) ? $options['fieldset'] : null;
            $view->vars['legend']   = isset($options['legend']) ? $options['legend'] : null;
            $view->vars['attr']['novalidate'] = 'novalidate';
            if (!isset($view->vars['attr']['class'])) {
                $view->vars['attr']['class'] = '';
            }
            $view->vars['attr']['class'] .= ' form-horizontal';
            $view->vars['attr']['class'] = trim($view->vars['attr']['class']);

            if (isset($options['role'])) {
                $view->vars['attr']['role'] = $options['role'];
            }

            if (isset($options['loading'])) {
                $view->vars['attr']['btn-loading'] = $options['loading'];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'fieldset' => true,
            'legend'   => false,
            'role'     => 'form',
            'loading'  => true,
        ));

        $resolver->setDefined(array(
            'fieldset',
            'legend',
            'role',
            'loading',
        ));
    }

    /**
     *
     */
    protected function disableAddSaveButtonSubscriber()
    {
        $this->addSaveButtonSubscriber = false;
    }

    /**
     *
     */
    protected function enableAddSaveButtonSubscriber()
    {
        $this->addSaveButtonSubscriber = true;
    }
}

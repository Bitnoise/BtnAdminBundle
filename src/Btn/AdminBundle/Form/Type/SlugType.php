<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SlugType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $this->assetLoader->load(array('btn_admin_slugify_js'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-slug'] = true;

        if ($options['slug_source'] && $form->getParent()->has($options['slug_source'])) {
            $view->vars['slug_source'] = $options['slug_source'];
            $view->vars['parent']      = $view->parent;
        } elseif (false === $options['slug_source']) {
            $view->vars['slug_source'] = false;
            $view->vars['parent'] = false;
        } else {
            throw new \Exception(sprintf('Could not find slug source field "%s"', $options['slug_source']));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(array(
            'slug_source',
        ));

        $resolver->setDefaults(array(
            'label'       => 'btn_admin.form.type.slug.label',
            'slug_source' => 'title',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_slug';
    }
}

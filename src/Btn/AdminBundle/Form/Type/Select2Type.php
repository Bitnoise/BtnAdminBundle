<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Select2Type extends AbstractType
{
    /** @var array $avliableParents */
    protected $avliableParents = array('choice', 'hidden', 'entity');
    /** @var string $parent */
    protected $parent;

    /**
     *
     */
    public function setParent($parent)
    {
        if (!in_array($parent, $this->avliableParents)) {
            throw new \InvalidArgumentException(sprintf(
                'Parent can be only on of: "%s", "%s" is given.',
                implode('", "', $this->avliableParents),
                $parent
            ));
        }

        $this->parent = $parent;
    }

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

        $resolver->setOptional(array(
            'searchable',
        ));

        $resolver->setAllowedTypes(array(
            'searchable' => array('bool', 'integer'),
        ));

        $resolver->setDefaults(array(
            'searchable' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['attr']['btn-select2'] = null;
        $view->vars['attr']['btn-select2-'.$this->parent] = null;

        if (false === $options['searchable']) {
            $view->vars['attr']['btn-select2-minimum-results-for-search'] = '-1';
        } elseif (is_int($options['searchable'])) {
            $view->vars['attr']['btn-select2-minimum-results-for-search'] = $options['searchable'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        if (!$this->parent) {
            throw new \Exception('Parent was not set via setParent() setter method.');
        }

        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_select2_'.$this->parent;
    }
}

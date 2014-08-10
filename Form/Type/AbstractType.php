<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType as BaseAbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractType extends BaseAbstractType
{
    /** @var string $class */
    protected $class;
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;
    /** @var \Symfony\Component\Translation\TranslatorInterface $translator */
    protected $translator;

    /**
     *
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     *
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     *
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        if ($this->class) {
            $resolver->setDefaults(array(
                'data_class' => $this->class,
            ));
        }
    }
}

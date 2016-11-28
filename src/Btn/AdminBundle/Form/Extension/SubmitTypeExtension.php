<?php

namespace Btn\AdminBundle\Form\Extension;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubmitTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['row'] = $options['row'];
        $view->vars['button'] = true;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(array(
            'row',
        ));

        $resolver->setAllowedTypes('row', array('bool'));

        $resolver->setDefaults(array(
            'row'  => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return Form::getFormName(array(
            'alias' => 'submit',
            'class' => SubmitType::class,
        ));
    }
}

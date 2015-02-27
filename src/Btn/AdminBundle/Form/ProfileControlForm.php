<?php

namespace Btn\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileControlForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('username', null, array(
                'label' => 'Username',
            ))
            ->add('email', null, array(
                'label' => 'Email',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'intention'  => 'profile',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_admin_form_profile_control';
    }
}

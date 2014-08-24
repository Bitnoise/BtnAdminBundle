<?php

namespace Btn\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordControlForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => array(
                 new UserPassword(),
            ),
        ));
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array(
                'translation_domain' => 'FOSUserBundle',
            ),
            'first_options' => array(
                'label' => 'form.new_password',
            ),
            'second_options' => array(
                'label' => 'form.new_password_confirmation',
            ),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'intention' => 'change_password',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_admin_form_change_password_control';
    }
}

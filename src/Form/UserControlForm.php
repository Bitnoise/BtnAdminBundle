<?php

namespace Btn\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class UserControlForm extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('username', null, array(
                'label' => 'btn_admin.user.username',
            ))
            ->add('email', null, array(
                'label' => 'btn_admin.user.email',
            ))
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array(
                    'label' => 'btn_admin.user.password'
                ),
                'second_options'  => array(
                    'label' => 'btn_admin.user.password_confirm'
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('enabled', null, array(
                'label' => 'btn_admin.user.enabled',
            ))
        ;
    }

    public function getName()
    {
        return 'btn_admin_form_user_control';
    }
}

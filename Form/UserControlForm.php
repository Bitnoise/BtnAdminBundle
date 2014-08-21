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
            // todo: fix crud form theme (BtnAdminBundle:Form:fields.html.twig) to handle the 'repeated' label block
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                // 'options'         => array('translation_domain' => 'FOSUserBundle'),
                'first_options'   => array('label' => 'btn_admin.user.password',
                                           'label_attr' => array('class' => 'col-sm-2 control-label')),
                'second_options'  => array('label' => 'btn_admin.user.password_confirm',
                                           'label_attr' => array('class' => 'col-sm-2 control-label')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('enabled', null, array(
                'label' => 'btn_admin.user.enabled',
            ))
            ->add('save', $options['data']->getId() ? 'btn_update' : 'btn_create')
        ;
    }

    public function getName()
    {
        return 'btn_admin_form_user_control';
    }
}

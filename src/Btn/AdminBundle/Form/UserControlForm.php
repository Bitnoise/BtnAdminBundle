<?php

namespace Btn\AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraint;

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
                    'label' => 'btn_admin.user.password',
                ),
                'second_options'  => array(
                    'label' => 'btn_admin.user.password_confirm',
                ),
                'invalid_message' => 'fos_user.password.mismatch',
                'constraints'     => array(
                    new Assert\NotBlank(array('groups' => array('Create'))),
                ),
            ))
            ->add('enabled', null, array(
                'label' => 'btn_admin.user.enabled',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();
                $groups = array(Constraint::DEFAULT_GROUP, 'Profile');
                if (!$data->getId()) {
                    $groups[] = 'Create';
                }

                return $groups;
            },
        ]);
    }

    public function getName()
    {
        return 'btn_admin_form_user_control';
    }
}

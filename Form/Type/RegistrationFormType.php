<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('create', 'btn_admin_create_button');
    }

    public function getName()
    {
        return 'btn_admin_user_add';
    }
}

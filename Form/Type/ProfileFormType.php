<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('update', 'btn_admin_update_button');
    }

    public function getName()
    {
        return 'btn_admin_edit';
    }
}

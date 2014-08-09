<?php

namespace Btn\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DeleteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('delete', 'btn_admin_delete_button')
        ;
    }

    public function getName()
    {
        return 'btn_admin_delete';
    }
}

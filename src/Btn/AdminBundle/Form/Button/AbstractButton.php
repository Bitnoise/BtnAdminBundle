<?php

namespace Btn\AdminBundle\Form\Button;

use Btn\AdminBundle\Form\Type\AbstractType;
use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

abstract class AbstractButton extends AbstractType implements SubmitButtonTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => 'submit',
            'class' => SubmitType::class,
        ));
    }
}

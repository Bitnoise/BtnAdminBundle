<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class Select2HiddenType extends Select2Type
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => HiddenType::class,
        ));
    }
}

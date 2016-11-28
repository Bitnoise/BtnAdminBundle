<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class Select2EntityType extends Select2Type
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => EntityType::class,
        ));
    }
}

<?php

namespace Btn\AdminBundle\Form\Type;

use Btn\BaseBundle\Util\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * {@inheritdoc}
 */
class Select2ChoiceType extends Select2Type
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Form::getFormName(array(
            'alias' => $this->getAlias(),
            'class' => ChoiceType::class,
        ));
    }
}

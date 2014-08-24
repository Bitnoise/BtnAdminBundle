<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Color extends Constraint
{
    public $message = 'This color is invalid';
}

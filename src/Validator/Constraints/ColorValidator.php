<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ColorValidator extends ConstraintValidator
{
    /**
     *
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!preg_match('~^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$~', $value, $matches)) {
            $this->context->addViolation($constraint->message);
        }
    }
}

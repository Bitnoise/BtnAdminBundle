<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Btn\BaseBundle\Util\Vimeo as VimeoUtil;

class VimeoValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (
            Vimeo::TYPE_DEFAULT === $constraint->type
            && !VimeoUtil::isValidId($value)
            && !VimeoUtil::isValidUrl($value)
        ) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

        if (Vimeo::TYPE_ID === $constraint->type && !VimeoUtil::isValidId($value)) {
            $this->context->buildViolation($constraint->messageId)->addViolation();
        }

        if (Vimeo::TYPE_URL === $constraint->type && !VimeoUtil::isValidUrl($value)) {
            $this->context->buildViolation($constraint->messageUrl)->addViolation();
        }
    }
}

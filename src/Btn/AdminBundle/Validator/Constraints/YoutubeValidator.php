<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Btn\BaseBundle\Util\Youtube as YoutubeUtil;

class YoutubeValidator extends ConstraintValidator
{
    /**
     *
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (
            Youtube::TYPE_DEFAULT === $constraint->type
            && !YoutubeUtil::isValidId($value)
            && !YoutubeUtil::isValidUrl($value)
        ) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }

        if (Youtube::TYPE_ID === $constraint->type && !YoutubeUtil::isValidId($value)) {
            $this->context->buildViolation($constraint->messageId)->addViolation();
        }

        if (Youtube::TYPE_URL === $constraint->type && !YoutubeUtil::isValidUrl($value)) {
            $this->context->buildViolation($constraint->messageUrl)->addViolation();
        }
    }
}

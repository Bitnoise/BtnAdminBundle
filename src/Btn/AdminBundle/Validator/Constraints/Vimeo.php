<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Vimeo extends Constraint
{
    const TYPE_ID      = 'id';
    const TYPE_URL     = 'url';
    const TYPE_DEFAULT = 'default';

    public $type       = 'default';
    public $message    = 'This is invalid vimeo id/url';
    public $messageId  = 'This is invalid vimeo id';
    public $messageUrl = 'This is invalid vimeo url';
}

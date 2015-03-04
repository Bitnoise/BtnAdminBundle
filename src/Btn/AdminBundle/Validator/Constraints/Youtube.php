<?php

namespace Btn\AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Youtube extends Constraint
{
    const TYPE_ID      = 'id';
    const TYPE_URL     = 'url';
    const TYPE_DEFAULT = 'default';

    public $type       = 'default';
    public $message    = 'This is invalid youtube id/url';
    public $messageId  = 'This is invalid youtube id';
    public $messageUrl = 'This is invalid youtube url';
}

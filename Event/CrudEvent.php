<?php

namespace Btn\ControlBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class CrudEvent extends Event
{
    /** @var stdClass $entity */
    private $entity;

    /**
     *
     */
    public function __construct(stdClass $user)
    {
        $this->user = $user;
    }

    /**
     *
     */
    public function getEntity()
    {
        return $this->user;
    }
}

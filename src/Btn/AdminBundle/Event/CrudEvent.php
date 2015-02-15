<?php

namespace Btn\AdminBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class CrudEvent extends Event
{
    /** @var stdClass $entity */
    private $entity;

    /**
     *
     */
    public function __construct($entity)
    {
        if (!is_object($entity) || !method_exists($entity, 'getId')) {
            throw new \Exception('This doesn\'t look like entity to me');
        }

        $this->entity = $entity;
    }

    /**
     *
     */
    public function getEntity()
    {
        return $this->entity;
    }
}

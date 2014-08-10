<?php

namespace Btn\AdminBundle\Provider;

use Doctrine\ORM\EntityManager;

abstract class AbstractEntityProvider implements EntityProviderInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;
    /** @var string $em */
    protected $className;

    /**
     *
     */
    public function __construct($className, EntityManager $em = null)
    {
        $this->className = $className;
        $this->em        = $em;
    }

    /**
     *
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     *
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     *
     */
    public function getClassName()
    {
        if (!$this->className) {
            throw new \Exception('Class name not defined');
        }

        return $this->className;
    }

    /**
     *
     */
    public function getRepository()
    {
        return $this->em->getRepository($this->getClassName());
    }

    /**
     *
     */
    public function createEntity()
    {
        $className = $this->getClassName();

        $entity = new $className();

        return $entity;
    }
}

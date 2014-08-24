<?php

namespace Btn\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManager;

class EntityToIdTransformer implements DataTransformerInterface
{
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;

    /** @var string $class */
    protected $class;

    /**
     *
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em    = $em;
        $this->class = $class;
    }

    /**
     *
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return;
        }

        return $entity->getId();
    }

    /**
     *
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->em->getRepository($this->class)->find($id);

        if (null === $entity) {
            throw new TransformationFailedException();
        }

        return $entity;
    }
}

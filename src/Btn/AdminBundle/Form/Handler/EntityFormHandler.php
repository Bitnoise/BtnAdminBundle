<?php

namespace Btn\AdminBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

/**
 *
 */
class EntityFormHandler implements FormHandlerInterface
{
    /** \Doctrine\ORM\EntityManager $entityManager */
    private $entityManager;

    /** @var bool $globalFlush */
    private $globalFlush;

    /**
     *
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->globalFlush   = false;
    }

    /**
     *
     */
    public function handle(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            if (!$entity->getId()) {
                $this->entityManager->persist($entity);
            }

            if ($this->globalFlush) {
                $this->entityManager->flush();
            } else {
                $this->entityManager->flush($entity);
            }

            return true;
        }
    }

    /**
     *
     */
    public function enableGlobalFlush()
    {
        $this->globalFlush = true;
    }

    /**
     *
     */
    public function disableGlobalFlush()
    {
        $this->globalFlush = false;
    }
}

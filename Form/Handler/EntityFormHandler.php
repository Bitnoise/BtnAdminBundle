<?php

namespace Btn\AdminBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

/**
 *
 */
class EntityFormHandler
{
    /** \Doctrine\ORM\EntityManager $em */
    private $em;
    /** \Symfony\Component\HttpFoundation\Request $requset */
    protected $request;

    /**
     *
     */
    public function __construct(EntityManager $em, Request $request = null)
    {
        $this->em      = $em;
        $this->request = $request;
    }

    /**
     *
     */
    public function handle(FormInterface $form, Request $request = null)
    {
        if (!$this->request || !$request) {
            throw new \Exception('No request pased to handler');
        }

        $form->handleRequest($request ? $request : $this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (!$data->getId()) {
                $this->em->persist($data);
            }

            $this->em->flush($data);

            return true;
        }
    }
}

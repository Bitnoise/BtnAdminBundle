<?php

namespace Btn\AdminBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 *
 */
class UserFormHandler implements FormHandlerInterface
{
    /** \FOS\UserBundle\Model\UserManagerInterface $userManager */
    private $userManager;

    /**
     *
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     *
     */
    public function handle(FormInterface $form, Request $request)
    {
        $form->handleRequest($request ? $request : $this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->userManager->updateUser($user);
            $this->userManager->reloadUser($user);

            return true;
        }
    }
}

<?php

namespace Btn\AdminBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    public function handle(FormInterface $form, Request $request = null);
}

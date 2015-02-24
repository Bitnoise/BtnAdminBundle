<?php

namespace Btn\AdminBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddFilterButtonSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => array('preSetData', -255),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        // if form is missing save button than add automaticly
        if (!$form->has('submit')) {
            $form->add('submit', 'btn_filter', array(
                'row' => false,
            ));
        }
    }
}

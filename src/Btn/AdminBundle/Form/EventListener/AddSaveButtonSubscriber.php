<?php

namespace Btn\AdminBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddSaveButtonSubscriber implements EventSubscriberInterface
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
     *
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // if form is missing save button than add automaticly
        if (!$form->has('save')) {
            if (is_object($data) && method_exists($data, 'getId') ) {
                $form->add('save', $data->getId() ? 'btn_update' : 'btn_create');
            } else {
                $form->add('save', 'btn_save');
            }
        }
    }
}

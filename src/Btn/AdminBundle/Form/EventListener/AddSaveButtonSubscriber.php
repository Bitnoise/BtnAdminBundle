<?php

namespace Btn\AdminBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddSaveButtonSubscriber extends AbstractButtonSubscriber
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
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // if form is missing save button than add automatically
        if (!$form->has('save')) {
            if (is_object($data) && method_exists($data, 'getId')) {
                $form->add('save', $this->getType($data->getId() ? 'btn_update' : 'btn_create'));
            } else {
                $form->add('save', $this->getType('btn_save'));
            }
        }
    }

}

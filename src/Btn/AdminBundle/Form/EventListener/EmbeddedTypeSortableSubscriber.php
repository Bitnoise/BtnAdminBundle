<?php

namespace Btn\AdminBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EmbeddedTypeSortableSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $this->fixDataOrder($event);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $this->fixDataOrder($event);
    }

    /**
     * @param FormEvent $event
     */
    private function fixDataOrder(FormEvent $event)
    {
        $data = $event->getData();

        // ignore non array data
        if (!is_array($data)) {
            return;
        }

        // ignore empty array data
        if (count($data) === 0) {
            return;
        }

        // check if array don't have string keys
        if (count(array_filter(array_keys($data), 'is_string')) > 0) {
            return;
        }

        // sort array in order by numeric keys
        ksort($data);

        // set data back to event
        $event->setData($data);
    }
}

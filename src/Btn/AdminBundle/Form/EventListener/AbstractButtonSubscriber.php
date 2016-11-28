<?php

namespace Btn\AdminBundle\Form\EventListener;

use Btn\BaseBundle\Form\FormRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractButtonSubscriber implements EventSubscriberInterface
{
    /** @var FormRegistry */
    protected $formRegistry;

    /**
     * @param FormRegistry $formRegistry
     */
    public function setFormRegistry(FormRegistry $formRegistry)
    {
        $this->formRegistry = $formRegistry;
    }

    /**
     * @param $alias
     *
     * @return mixed
     */
    protected function getType($alias)
    {
        if ($this->formRegistry && $this->formRegistry->hasType($alias)) {
            return $this->formRegistry->getType($alias);
        }

        return $alias;
    }
}

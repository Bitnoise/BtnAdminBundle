<?php

namespace Btn\AdminBundle\Annotation;

/**
 * @Annotation
 */
class EntityProvider
{
    /** @var string $serviceId */
    private $serviceId;

    /**
     *
     */
    public function __construct($options)
    {
        if (isset($options['value'])) {
            $options['serviceId'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    /**
     *
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }
}

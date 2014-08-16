<?php

namespace Btn\AdminBundle\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class EntityProvider
{
    /** @var string $providerId */
    protected $providerId;

    /**
     *
     */
    public function __construct($options)
    {
        if (isset($options['value'])) {
            $options['providerId'] = $options['value'];
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
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;

        return $this;
    }

    /**
     *
     */
    public function getProviderId()
    {
        return $this->providerId;
    }
}

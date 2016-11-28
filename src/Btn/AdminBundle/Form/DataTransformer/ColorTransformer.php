<?php

namespace Btn\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ColorTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $color
     *
     * @return mixed|string
     */
    public function transform($color)
    {
        if (null === $color) {
            return '';
        }

        return ltrim($color, '#');
    }

    /**
     * @param mixed $color
     *
     * @return mixed|string|void
     */
    public function reverseTransform($color)
    {
        if (!$color) {
            return;
        }

        return '#'.ltrim($color, '#');
    }
}

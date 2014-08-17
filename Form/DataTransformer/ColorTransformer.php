<?php

namespace Btn\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ColorTransformer implements DataTransformerInterface
{
    /**
     *
     */
    public function transform($color)
    {
        if (null === $color) {
            return "";
        }

        return ltrim($color, '#');
    }

    /**
     *
     */
    public function reverseTransform($color)
    {
        if (!$color) {
            return null;
        }

        return '#' . ltrim($color, '#');
    }
}

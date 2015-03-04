<?php

namespace Btn\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Btn\AdminBundle\ValueObject\Youtube;

class YoutubeTransformer implements DataTransformerInterface
{
    /**
     *
     */
    public function transform($video)
    {
        if (null === $video) {
            return;
        }

        return Youtube::create($video);
    }

    /**
     *
     */
    public function reverseTransform($video)
    {
        if (!$video) {
            return;
        }

        return (string) $video;
    }
}

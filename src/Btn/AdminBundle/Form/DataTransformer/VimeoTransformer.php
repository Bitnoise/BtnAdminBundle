<?php

namespace Btn\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Btn\AdminBundle\ValueObject\Vimeo;

class VimeoTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $video
     *
     * @return Vimeo|mixed|void
     */
    public function transform($video)
    {
        if (null === $video) {
            return;
        }

        return Vimeo::create($video);
    }

    /**
     * @param mixed $video
     *
     * @return mixed|string|void
     */
    public function reverseTransform($video)
    {
        if (!$video) {
            return;
        }

        return (string) $video;
    }
}

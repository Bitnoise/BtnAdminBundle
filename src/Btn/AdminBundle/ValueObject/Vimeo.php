<?php

namespace Btn\AdminBundle\ValueObject;

use Btn\BaseBundle\Util\Vimeo as VimeoUtil;

class Vimeo
{
    private $video;

    /**
     * @param $video
     *
     * @throws \Exception
     */
    public function __construct($video)
    {
        if (!VimeoUtil::isValidUrl($video) && !VimeoUtil::isValidId($video)) {
            throw new \Exception(sprintf('Invalid video string "%s"', $video));
        }

        $this->video = $video;
    }

    /**
     *
     */
    public function getVideoId()
    {
        return $this->video ? VimeoUtil::getVideoId($this->video) : null;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->video;
    }

    /**
     * @param $video
     *
     * @return Vimeo
     */
    public static function create($video)
    {
        return new self($video);
    }
}

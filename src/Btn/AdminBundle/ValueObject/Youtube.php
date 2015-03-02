<?php

namespace Btn\AdminBundle\ValueObject;

use Btn\BaseBundle\Util\Youtube as YoutubeUtil;

class Youtube
{
    private $video;

    /**
     *
     */
    public function __construct($video)
    {
        if (!YoutubeUtil::isValidUrl($video) && !YoutubeUtil::isValidId($video)) {
            throw new \Exception(sprintf('Invalid video string "%s"', $video));
        }

        $this->video = $video;
    }

    /**
     *
     */
    public function getVideoId()
    {
        return $this->video ? YoutubeUtil::getVideoId($this->video) : null;
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->video;
    }

    /**
     *
     */
    public static function create($video)
    {
        return new self($video);
    }
}

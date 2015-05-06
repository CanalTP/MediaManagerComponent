<?php

namespace CanalTP\MediaManager\Media;

use CanalTP\MediaManager\Media\PictureMediaType;
use CanalTP\MediaManager\Media\GenericMedia;
use CanalTP\MediaManager\Media\MediaType;

class PictureMedia extends GenericMedia
{
    private $width = null;
    private $length = null;

    public function __construct()
    {
        parent::__construct();

        $this->mediaType = MediaType::PICTURE;
        $this->type = PictureMediaType::UNKNOWN;
        $this->width = 0;
        $this->length = 0;
    }

    public function getWidth()
    {
        return ($this->width);
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return ($this->length);
    }

    public function setLength($length)
    {
        $this->length = $length;
    }
}

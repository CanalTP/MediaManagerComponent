<?php

namespace CanalTP\MediaManager\Media;

use CanalTP\MediaManager\Media\SoundMediaType;
use CanalTP\MediaManager\Media\GenericMedia;
use CanalTP\MediaManager\Media\MediaType;

class SoundMedia extends GenericMedia
{
    public function __construct()
    {
        parent::__construct();

        $this->mediaType = MediaType::SOUND;
        $this->type = SoundMediaType::UNKNOWN;
    }
}

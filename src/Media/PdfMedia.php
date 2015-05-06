<?php

namespace CanalTP\MediaManager\Media;

use CanalTP\MediaManager\Media\GenericMedia;
use CanalTP\MediaManager\Media\MediaType;

class PdfMedia extends GenericMedia
{
    public function __construct()
    {
        parent::__construct();

        $this->mediaType = MediaType::PDF;
        $this->type = MediaType::PDF;
    }
}

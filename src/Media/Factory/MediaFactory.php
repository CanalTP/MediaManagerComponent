<?php

namespace CanalTP\MediaManager\Media\Factory;

use CanalTP\MediaManager\Media\MediaType;
use CanalTP\MediaManager\Media\SoundMedia;
use CanalTP\MediaManager\Media\PictureMedia;
use CanalTP\MediaManager\Media\PdfMedia;
use CanalTP\MediaManager\Media\Factory\MediaFactoryInterface;
use CanalTP\MediaManager\Media\GenericMedia;

class MediaFactory implements MediaFactoryInterface
{
    private $mime = null;
    private $type = null;

    private function analyse($fileName)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->mime = finfo_file($finfo, $fileName);
        finfo_close($finfo);
    }

    private function determine()
    {
        $this->type = null;

        switch ($this->mime) {
            case 'image/jpeg':
                $this->type = MediaType::PICTURE;
                break;
            case 'image/png':
                $this->type = MediaType::PICTURE;
                break;
            case 'audio/mpeg':
                $this->type = MediaType::SOUND;
                break;
            case 'application/pdf':
                $this->type = MediaType::PDF;
                break;
            default:
                $this->type = MediaType::UNKNOWN;
        }
    }

    private function product()
    {
        $media = null;

        switch ($this->type) {
            case MediaType::SOUND:
                $media = new SoundMedia();
                break;
            case MediaType::PICTURE:
                $media = new PictureMedia();
                break;
            case MediaType::PDF:
                $media = new PdfMedia();
                break;
            case MediaType::UNKNOWN:
                $media = new GenericMedia();
                break;
        }

        return ($media);
    }

    public function create($fileName)
    {
        $this->analyse($fileName);
        $this->determine();

        return ($this->product());
    }
}

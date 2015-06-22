<?php

namespace CanalTP\MediaManager\Company;

use CanalTP\MediaManager\Company\CompanyInterface;
use CanalTP\MediaManager\Category\CategoryInterface;
use CanalTP\MediaManager\Media\MediaInterface;
use CanalTP\MediaManager\Company\Configuration\ConfigurationInterface;
use CanalTP\MediaManager\Storage\StorageModeType;

class Company implements CompanyInterface
{
    private $configuration = null;
    private $name = null;
    private $id = null;

    public function __construct()
    {
        $this->name = 'Unknown';
        $this->id = '0';
    }

    public function getStorage()
    {
        return ($this->configuration->getStorage());
    }

    public function getStrategy()
    {
        return ($this->configuration->getStrategy());
    }

    public function setConfiguration(ConfigurationInterface $config)
    {
        $this->configuration = $config;
    }

    public function getConfiguration()
    {
        return ($this->configuration);
    }

    public function getId()
    {
        return ($this->id);
    }

    public function setId($newId)
    {
        $this->id = $newId;
    }

    public function getName()
    {
        return ($this->name);
    }

    public function setName($newName)
    {
        $this->name = $newName;
    }

    public function addMedia(MediaInterface $media, $mode = StorageModeType::MOVE)
    {
        return ($this->getStorage()->addMedia($media, $this->getStrategy(), $mode));
    }

    public function getMediasByCategory(CategoryInterface $category)
    {
        return (
            $this->getStorage()->getMediasByCategory(
                $this,
                $this->getStrategy(),
                $category
            )
        );
    }

    public function findMedia(CategoryInterface $category, $mediaId)
    {
        return (
            $this->getStorage()->findMedia(
                $this,
                $this->getStrategy(),
                $category,
                $mediaId
            )
        );
    }

    public function removeMedia(CategoryInterface $category, $basename, $force)
    {
        return (
            $this->getStorage()->removeMedia(
                $this,
                $this->getStrategy(),
                $category,
                $basename,
                $force
            )
        );
    }

    public function removeCategory(CategoryInterface $category, $force)
    {
        return (
            $this->getStorage()->removeCategory(
                $this,
                $this->getStrategy(),
                $category,
                $force
            )
        );
    }
}

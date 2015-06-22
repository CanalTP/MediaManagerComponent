<?php

namespace CanalTP\MediaManager\Storage;

use CanalTP\MediaManager\Company\CompanyInterface;
use CanalTP\MediaManager\Strategy\StrategyInterface;
use CanalTP\MediaManager\Category\CategoryInterface;
use CanalTP\MediaManager\Media\MediaInterface;

interface StorageInterface
{
    public function addMedia(
        MediaInterface $media,
        StrategyInterface $strategy,
        $mode = CompanyInterface::MOVE
    );

    public function getMediasByCategory(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category
    );

    public function findMedia(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $mediaId
    );

    public function removeMedia(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $basename,
        $force
    );

    public function removeCategory(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $force
    );

    public function getTrashDir();

    public function getPath();
    public function setPath($path);
}

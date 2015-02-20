<?php

namespace CanalTP\MediaManager\Storage;

use CanalTP\MediaManager\Company\CompanyInterface;
use CanalTP\MediaManager\Strategy\StrategyInterface;
use CanalTP\MediaManager\Category\CategoryInterface;
use CanalTP\MediaManager\Media\MediaInterface;
use CanalTP\MediaManager\Storage\AbstractStorage;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use Symfony\Component\HttpFoundation\File\File;

class FileSystem extends AbstractStorage
{
    private function move($src, $dest)
    {
        $result = copy($src, $dest);

        unlink($src);
        return ($result);
    }

    private function remove(
        $path,
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $basename = false
    ) {
        $destDir = $this->getTrashDir();
        $destDir .= $strategy->generateRelativeCategoryPath(
            $company,
            $category
        );
        $basename = ($basename) ? $basename : basename($path);

        if (!file_exists($destDir))
        {
            mkdir($destDir, 0777, true);
        }
        return ($this->move($path, $destDir . $basename));
    }

    public function addMedia(
        MediaInterface $media,
        StrategyInterface $strategy
        ) {
        $result = false;
        $path = $this->getPath();
        $path .= $strategy->generatePath($media);

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        // Remove all files who have the same name that new file and  without checking file's extension
        $listFile = array_diff(scandir(dirname($path)), array('..', '.'));
        foreach ($listFile as $file) {
            $info = pathinfo($file);
            if ($info['filename'] == $media->getFileName()) {
                unlink(dirname($path) . '/' . $file);
            }
        }
        // TODO: Remove this function when rename function will be patched
        // -----> https://bugs.php.net/bug.php?id=54097
        $result = $this->move($media->getPath(), $path);
        $media->setPath($path);
        // if ($result = rename($media->getPath(), $path)) {
        //     $media->setPath($path);
        // }

        return ($result);
    }

    public function getMediasByCategory(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category
        ) {
        $files = $strategy->getMediasPathByCategory($company, $category);
        $mediaBuilder = new MediaBuilder();

        foreach ($files as $file) {
            $category->addMedia(
                $mediaBuilder->buildMedia(
                    $file,
                    $company,
                    $category
                )
            );
        }

        return ($category->getMedias());
    }

    public function findMedia(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $mediaId
        ) {
        $path = $strategy->findMedia($company, $category, $mediaId);
        if (!$path) {
            return (null);
        }

        $mediaBuilder = new MediaBuilder();

        $media = $mediaBuilder->buildMedia(
            $path,
            $company,
            $category
        );

        return ($media);
    }

    public function removeMedia(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $basename,
        $force
        ) {
        $result = false;
        $path = $strategy->findMedia($company, $category, $basename);

        if (file_exists($path)) {
            $result = (($force) ? unlink($path) : $this->remove($path, $company, $strategy, $category, $basename));
        }
        return ($result);
    }

    public function removeCategory(
        CompanyInterface $company,
        StrategyInterface $strategy,
        CategoryInterface $category,
        $force
        ) {
        $result = false;
        $path = $strategy->generateCategoryPath($company, $category);

        foreach (glob($path . '*') as $mediaPath) {
            $result = (($force) ? unlink($mediaPath) : $this->remove($mediaPath, $company, $strategy, $category));
        }
        return ($result);
    }
}

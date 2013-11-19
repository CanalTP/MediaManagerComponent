<?php

namespace CanalTP\MediaManager\Strategy;

use CanalTP\MediaManager\Company\CompanyInterface;
use CanalTP\MediaManager\Category\CategoryInterface;
use CanalTP\MediaManager\Strategy\AbstractStrategy;

class DefaultStrategy extends AbstractStrategy
{
    private $pathFound = "";

    private function buildPath($path, $category)
    {
        if ($category->getParent()) {
            $path .= $this->buildPath($path, $category->getParent());
        }
        $path .= $category->getName() . '/';

        return ($path);
    }

    public function generatePath($media)
    {
        $category = $media->getCategory();
        $path = $media->getCompany()->getName() . '/';

        $path .= $this->buildPath("", $category);
        $path .= $media->getBaseName();

        return ($path);
    }

    private function findCategory($path, $name)
    {
        $results = array_diff(scandir($path), array('.', '..'));

        foreach ($results as $result) {

            $current_path = $path . '/' . $result;
            $is_dir = is_dir($current_path);

            if ($is_dir && $result == $name) {
                $this->pathFound = $current_path;
                break ;
            } elseif ($is_dir) {
                $this->findCategory($current_path, $name);
            }
        }
    }

    public function getMediasPathByCategory(
        CompanyInterface $company,
        CategoryInterface $category
    )
    {
        $medias = array();
        $path = $company->getStorage()->getPath() . $company->getName();

        if (!file_exists($path)) {
            return ($medias);
        }
        $this->findCategory($path, $category->getId());
        $files = array_diff(scandir($this->pathFound), array('..', '.'));
        foreach ($files as $file) {
            $mediaPath = $this->pathFound . '/' . $file;

            if (!is_dir($mediaPath)) {
                array_push($medias, $mediaPath);
            }
        }

        return ($medias);
    }
}

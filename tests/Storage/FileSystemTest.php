<?php

namespace CanalTP\MediaManager\Test\Storage;

use CanalTP\MediaManager\Test\AbstractTest;
use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Company\Configuration\Configuration;
use CanalTP\MediaManager\Company\Company;
use CanalTP\MediaManager\Category\DefaultCategory;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;

class FileSystemTest extends AbstractTest
{
    private $filePath = null;

    public function setUp()
    {
        $mediaBuilder = new MediaBuilder();
        $params = array(
            'name' => Registry::get('COMPANY_NAME'),
            'storage' => array(
                'type' => 'filesystem',
                'path' => '/tmp/MediaManager/',
            ),
            'strategy' => Registry::get('DEFAULT_STRATEGY_NAME')
        );
        $category = new DefaultCategory();
        $category->setName(Registry::get('CATEGORY_NAME'));
        $this->company = new Company();
        $this->company->setName($params['name']);
        $this->configBuilder = new ConfigurationBuilder();

        $this->company->setConfiguration(
            $this->configBuilder->buildConfiguration($params)
        );
        $this->filePath = Registry::get('/') . Registry::get('SOUND_FILE');
        $this->media = $mediaBuilder->buildMedia(
            $this->filePath,
            $this->company,
            $category
        );

        $this->assertTrue(
            file_exists($this->filePath),
            Registry::get('FILE_EXIST')
        );
    }

    public function testAddMedia()
    {
        $this->assertTrue(
            $this->company->addMedia($this->media),
            Registry::get('STORAGE_MOVE')
        );
        $this->assertFalse(
            file_exists($this->filePath),
            Registry::get('STORAGE_MOVE')
        );
    }

    public function tearDown()
    {
        rename($this->media->getPath(), $this->filePath);
        parent::tearDown();
    }
}

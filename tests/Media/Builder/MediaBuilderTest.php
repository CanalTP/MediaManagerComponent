<?php

namespace CanalTP\MediaManager\Test\Media\Builder;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use CanalTP\MediaManager\Category\DefaultCategory;
use CanalTP\MediaManager\Company\Company;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;

class MediaBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder = null;
    private $category = null;
    private $company = null;
    private $mediaPath = null;

    public function setUp()
    {
        $params = array(
            'name' => 'my_company',
            'storage' => array(
                'type' => 'filesystem',
                'path' => '/tmp/MediaManager/',
            ),
            'strategy' => Registry::get('DEFAULT_STRATEGY_NAME')
        );
        $this->mediaPath = Registry::get('/') . Registry::get('SOUND_FILE');
        $configBuilder = new ConfigurationBuilder();
        $this->builder = new MediaBuilder();
        $this->company = new Company();
        $this->company->setConfiguration(
            $configBuilder->buildConfiguration($params)
        );
        $this->category = new DefaultCategory();
    }

    public function testBuildMedia()
    {
        $media = $this->builder->buildMedia(
            $this->mediaPath,
            $this->company,
            $this->category
        );
    }

    public function testGetMedia()
    {
        $media = $this->builder->buildMedia(
            $this->mediaPath,
            $this->company,
            $this->category
        );
        $this->assertInstanceOf(
            Registry::get('MEDIA_INTERFACE'),
            $media,
            Registry::get('BAD_RETURN')
        );
    }
}

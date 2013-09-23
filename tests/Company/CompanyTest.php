<?php

namespace CanalTP\MediaManager\Test\Company;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Company\Configuration\Configuration;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use CanalTP\MediaManager\Category\Factory\CategoryFactory;
use CanalTP\MediaManager\Category\CategoryType;
use CanalTP\MediaManager\Company\Company;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    private $company = null;
    private $category = null;
    private $media = null;

    public function setUp()
    {
        $params = array(
            'name' => Registry::get('COMPANY_NAME'),
            'storage' => array(
                'type' => 'filesystem',
                'path' => '/tmp/MediaManager/',
            ),
            'strategy' => Registry::get('STRATEGY_NAME')
        );

        $this->company = new Company();
        $configurationBuilder = new ConfigurationBuilder();
        $mediaBuilder = new MediaBuilder();
        $categoryFactory = new CategoryFactory();

        $this->company->setConfiguration(
            $configurationBuilder->buildConfiguration($params)
        );

        $this->networkCategory = $categoryFactory->create(
            CategoryType::NETWORK
        );
        $this->category = $categoryFactory->create(CategoryType::LINE);
        $this->category->setName(Registry::get('CATEGORY_NAME'));
        $this->category->setId(Registry::get('CATEGORY_NAME'));
        $this->category->setParent($this->networkCategory);

        $this->media = $mediaBuilder->buildMedia(
            Registry::get('/') . Registry::get('SOUND_FILE'),
            $this->company,
            $this->category
        );

        $this->company->setName(Registry::get('COMPANY_NAME'));
        $this->company->addMedia($this->media);
    }

    public function testInitialisation()
    {
        $company = new Company();

        $this->assertNull(
            $company->getConfiguration(),
            Registry::get('NOT_INIT')
        );
    }

    public function testGetConfiguration()
    {
        $this->assertInstanceOf(
            Registry::get('CONFIGURATION_INTERFACE'),
            $this->company->getConfiguration(),
            Registry::get('BAD_RETURN')
        );
    }

    public function testSetAndGetName()
    {
        $company = new Company();

        $newName = 'My Company';
        $name = $company->getName();

        $this->assertInternalType('string', $name);
        $this->assertEquals(
            $name, 'Unknown',
            Registry::get('NOT_INIT')
        );
        $company->setName($newName);
        $this->assertEquals(
            $company->getName(),
            $newName,
            Registry::get('NOT_SET')
        );
    }

    public function testGetStorage()
    {
        $this->assertInstanceOf(
            Registry::get('STORAGE_INTERFACE'),
            $this->company->getStorage(),
            Registry::get('NOT_SET')
        );
    }

    public function testGetStrategy()
    {
        $this->assertInstanceOf(
            Registry::get('STRATEGY_INTERFACE'),
            $this->company->getStrategy(),
            Registry::get('NOT_SET')
        );
    }

    public function testRemoveMedia()
    {
        $data_path = Registry::get('/') . Registry::get('SOUND_FILE');
        $path = $this->company->getStorage()->getPath();

        copy($this->media->getPath(), $data_path);
        $this->assertTrue(
            $this->company->removeMedia(
                $this->networkCategory,
                $this->media->getBaseName()
            )
        );
        $this->assertFalse(
            $this->company->removeMedia(
                $this->networkCategory,
                $this->media->getBaseName()
            )
        );
        rename($data_path, $this->media->getPath());
    }

    public function testGetMediasByCategory()
    {
        $medias = $this->company->getMediasByCategory(
            $this->networkCategory
        );

        foreach ($medias as $media) {
            $this->assertInstanceOf(
                Registry::get('MEDIA_INTERFACE'),
                $media,
                Registry::get('NOT_SET')
            );
        }
        $this->assertEquals(1, $this->networkCategory->getMediaNumber());
    }

    public function tearDown()
    {
        $data_path = Registry::get('/') . Registry::get('SOUND_FILE');
        $path = $this->company->getStorage()->getPath();

        rename($this->media->getPath(), $data_path);
        rmdir(dirname($this->media->getPath()));
        $path = $path . Registry::get('COMPANY_NAME');
        rmdir($path . '/' . Registry::get('NETWORK_NAME'));
        $path = $this->company->getStorage()->getPath();
        rmdir($path . Registry::get('COMPANY_NAME'));
        rmdir($this->company->getStorage()->getPath());
    }
}

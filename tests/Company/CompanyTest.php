<?php

namespace CanalTP\MediaManager\Test\Company;

use CanalTP\MediaManager\Test\AbstractTest;
use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Company\Configuration\Configuration;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use CanalTP\MediaManager\Category\Factory\CategoryFactory;
use CanalTP\MediaManager\Company\Company;

class CompanyTest extends AbstractTest
{
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

    public function testSetAndGetId()
    {
        $company = new Company();
        $newId = 'My Id';
        $id = $company->getId();

        $this->assertInternalType('string', $id);
        $this->assertEquals(
            $id, '0',
            Registry::get('NOT_INIT')
        );
        $company->setId($newId);
        $this->assertEquals(
            $company->getId(),
            $newId,
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

    public function testFindMedia()
    {
        // TODO: Decomment this.
        // $this->assertNotNull(
        //     $this->company->findMedia(
        //         $this->category,
        //         Registry::get('SOUND_FILE')
        //     )
        // );
        // $this->assertNull(
        //     $this->company->findMedia(
        //         $this->category,
        //         Registry::get('UNKNOWN')
        //     )
        // );
    }

    public function testRemoveMedia()
    {
        $data_path = Registry::get('/') . Registry::get('SOUND_FILE');
        $path = $this->company->getStorage()->getPath();

        copy($this->media->getPath(), $data_path);
        $this->assertTrue(
            $this->company->removeMedia(
                $this->category,
                $this->media->getBaseName(),
                true
            )
        );
        $this->assertFalse(
            $this->company->removeMedia(
                $this->category,
                $this->media->getBaseName(),
                true
            )
        );
        rename($data_path, $this->media->getPath());
    }

    public function testGetMediasByCategory()
    {
        $medias = $this->company->getMediasByCategory(
            $this->category
        );

        foreach ($medias as $media) {
            $this->assertInstanceOf(
                Registry::get('MEDIA_INTERFACE'),
                $media,
                Registry::get('NOT_SET')
            );
        }
        $this->assertEquals(1, $this->category->getMediaNumber());
    }

    public function tearDown()
    {
        $dataPath = Registry::get('/') . Registry::get('SOUND_FILE');
        rename($this->media->getPath(), $dataPath);
        parent::tearDown();
    }
}

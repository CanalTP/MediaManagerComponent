<?php

namespace CanalTP\MediaManager\Test\Category;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Media\Factory\MediaFactory;
use CanalTP\MediaManager\Category\AbstractCategory;
use CanalTP\MediaManager\Category\DefaultCategory;

class AbstractCategoryTest extends \PHPUnit_Framework_TestCase
{
    private $stub = null;

    public function setUp()
    {
        $namespace = 'CanalTP\MediaManager\Category\AbstractCategory';
        $this->stub = $this->getMockForAbstractClass($namespace);
    }

    public function testInitialisation()
    {
        $this->assertEquals(
            $this->stub->getName(), 'Unknown',
            Registry::get('NOT_INIT')
        );
    }

    public function testSetAndGetName()
    {
        $this->stub->setName('Category');
        $this->assertEquals(
            $this->stub->getName(), 'Category',
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetId()
    {
        $this->stub->setId('Id');
        $this->assertEquals(
            $this->stub->getId(), 'Id',
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetParent()
    {
        $category = new DefaultCategory();

        $this->stub->setParent($category);
        $this->assertInstanceOf(
            Registry::get('CATEGORY_INTERFACE'),
            $this->stub->getParent(),
            Registry::get('NOT_SET')
        );
    }

    public function testGetRessourceId()
    {
        $this->assertEquals(
            $this->stub->getRessourceId(), 'Unknown',
            Registry::get('NOT_SET')
        );
    }

    public function testAddMedia()
    {
        $sFile = Registry::get('/') . Registry::get('SOUND_FILE');
        $pFile = Registry::get('/') . Registry::get('PICTURE_FILE');
        $factory = new MediaFactory();
        $sound = $factory->create($sFile);
        $picture = $factory->create($pFile);

        $this->stub->addMedia($sound);
        $this->assertEquals(
            $this->stub->getMediaNumber(), 1,
            Registry::get('CATEGORY_ADD_MEDIA')
        );
        $this->stub->addMedia($picture);
        $this->assertEquals(
            $this->stub->getMediaNumber(), 2,
            Registry::get('CATEGORY_ADD_MEDIA')
        );
    }
}

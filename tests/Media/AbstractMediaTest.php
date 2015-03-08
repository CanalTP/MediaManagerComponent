<?php

namespace CanalTP\MediaManager\Test\Media;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Company\Company;
use CanalTP\MediaManager\Media\MediaType;
use CanalTP\MediaManager\Media\SoundMediaType;
use CanalTP\MediaManager\Category\DefaultCategory;

class AbstractMediaTest extends \PHPUnit_Framework_TestCase
{
    private $stub = null;

    protected function setUp()
    {
        $namespace = 'CanalTP\MediaManager\Media\AbstractMedia';
        $this->stub = $this->getMockForAbstractClass($namespace);
    }

    public function testInitialisation()
    {
        $this->assertInternalType(
            'integer', $this->stub->getMediaType(),
            Registry::get('NOT_CORRECT')
        );
        $this->assertEquals(
            $this->stub->getMediaType(), MediaType::UNKNOWN,
            Registry::get('NOT_CORRECT')
        );
        $this->assertInternalType(
            'integer', $this->stub->getSize(),
            Registry::get('NOT_INIT')
        );
        $this->assertEquals(
            $this->stub->getSize(), 0,
            Registry::get('NOT_INIT')
        );
    }

    public function testSetAndGetFileName()
    {
        $fileName = $this->stub->getFileName();

        $this->assertInternalType('string', $fileName);
        $this->assertEquals(
            $fileName, Registry::get('UNKNOWN'),
            Registry::get('NOT_INIT')
        );
        $this->stub->setFileName(Registry::get('FILE_NAME'));
        $this->assertEquals(
            $this->stub->getFileName(), Registry::get('FILE_NAME'),
            Registry::get('NOT_SET')
        );
        $this->assertEquals(
            $this->stub->getBaseName(),
            Registry::get('FILE_NAME') . '.' . Registry::get('UNKNOWN'),
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetBaseName()
    {
        $baseName = $this->stub->getBaseName();

        $this->assertInternalType('string', $baseName);
        $this->assertEquals(
            $baseName, Registry::get('UNKNOWN').'.'.Registry::get('UNKNOWN'),
            Registry::get('NOT_INIT')
        );
        $this->stub->setBaseName(Registry::get('BASE_NAME'));
        $this->assertEquals(
            $this->stub->getBaseName(), Registry::get('BASE_NAME'),
            Registry::get('NOT_SET')
        );
        $this->assertEquals(
            $this->stub->getFileName(),
            pathinfo(Registry::get('BASE_NAME'), PATHINFO_FILENAME),
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetType()
    {
        $type = $this->stub->getType();

        $this->assertInternalType('integer', $type);
        $this->assertEquals(
            $type, SoundMediaType::UNKNOWN,
            Registry::get('NOT_INIT')
        );
        $this->stub->setType(SoundMediaType::UNKNOWN);
        $this->assertEquals(
            $this->stub->getType(), SoundMediaType::UNKNOWN,
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetMediaType()
    {
        $mediaType = $this->stub->getMediaType();

        $this->assertInternalType('integer', $mediaType);
        $this->assertEquals(
            $mediaType, MediaType::UNKNOWN,
            Registry::get('NOT_INIT')
        );
        $this->stub->setMediaType(MediaType::SOUND);
        $this->assertEquals(
            $this->stub->getMediaType(), MediaType::SOUND,
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetSize()
    {
        $size = $this->stub->getSize();

        $this->assertInternalType('integer', $size);
        $this->assertNotNull($size, Registry::get('NOT_INIT'));
        $this->stub->setSize(42.42);
        $this->assertEquals(
            $this->stub->getSize(), 42.42,
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetExpirationDate()
    {
        $expirationDate = $this->stub->getExpirationDate();
        $date = strtotime("+1 week");

        $this->assertInternalType('integer', $expirationDate);
        $this->assertNotNull($expirationDate, Registry::get('NOT_INIT'));
        $this->stub->setExpirationDate($date);
        $this->assertEquals(
            $this->stub->getExpirationDate(), $date,
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetPath()
    {
        $this->assertNull($this->stub->getPath(), Registry::get('NOT_INIT'));
        $this->stub->setPath("/my/path/");
        $this->assertInternalType('string', $this->stub->getPath());
        $this->assertEquals(
            $this->stub->getPath(), "/my/path/",
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetCompany()
    {
        $params = array(
            'name' => 'my_company',
            'storage' => array(
                'type' => 'filesystem',
                'path' => '/tmp/MediaManager/',
            ),
            'strategy' => Registry::get('DEFAULT_STRATEGY_NAME')
        );
        $configBuilder = new ConfigurationBuilder();
        $company = new Company();
        $company->setConfiguration($configBuilder->buildConfiguration($params));
        $this->assertNull(
            $this->stub->getCompany(),
            Registry::get('NOT_INIT')
        );
        $this->stub->setCompany($company);
        $this->assertInstanceOf(
            Registry::get('COMPANY_INTERFACE'),
            $this->stub->getCompany(),
            Registry::get('NOT_SET')
        );
        $this->assertEquals(
            $this->stub->getCompany(),
            $company, Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetCategory()
    {
        $category = new DefaultCategory();

        $this->assertNull(
            $this->stub->getCategory(),
            Registry::get('NOT_INIT')
        );
        $this->stub->setCategory($category);
        $this->assertEquals(
            $this->stub->getCategory(), $category,
            Registry::get('NOT_SET')
        );
    }

    public function testSetAndGetExtension()
    {
        $extension = $this->stub->getExtension();

        $this->assertInternalType('string', $extension);
        $this->assertEquals(
            $extension, Registry::get('UNKNOWN'),
            Registry::get('NOT_INIT')
        );
        $this->stub->setExtension(Registry::get('EXTENSION_NAME'));
        $this->assertEquals(
            $this->stub->getExtension(), Registry::get('EXTENSION_NAME'),
            Registry::get('NOT_SET')
        );
    }
}

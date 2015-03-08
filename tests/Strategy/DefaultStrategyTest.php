<?php

namespace CanalTP\MediaManager\Test\Strategy;

use CanalTP\MediaManager\Test\AbstractTest;
use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Company\Configuration\Configuration;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use CanalTP\MediaManager\Category\Factory\CategoryFactory;
use CanalTP\MediaManager\Company\Company;

class DefaultStrategyTest extends AbstractTest
{
    private $strategy = null;

    public function testGeneratePath()
    {
        $path = 'Divia/networks/network_id/routes/route_id/jingle_SNCF.mp3';
        $result = $this->company->getStrategy()->generatePath($this->media);

        $this->assertInternalType('string', $result);
        $this->assertEquals(
            $result, $path,
            Registry::get('STRATEGY_PATH')
        );
    }

    public function testFindCategory()
    {
        $this->category->setRessourceId(Registry::get('UNKNOWN'));
        $result = $this->company->getStrategy()->getMediasPathByCategory(
            $this->company,
            $this->category
        );

        $this->assertEquals(count($result), 0);

        $this->company->setName(Registry::get('UNKNOWN'));
        $result = $this->company->getStrategy()->getMediasPathByCategory(
            $this->company,
            $this->category
        );
        $this->assertEquals(count($result), 0);
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

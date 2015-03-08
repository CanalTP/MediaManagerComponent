<?php

namespace CanalTP\MediaManager\Test;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;
use CanalTP\MediaManager\Media\Builder\MediaBuilder;
use CanalTP\MediaManager\Company\Company;
use CanalTP\MediaManager\Category\DefaultCategory;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    protected $company = null;
    protected $category = null;
    protected $media = null;

    private function generateNetworkCategory()
    {
        $network = new DefaultCategory();

        $network->setName(Registry::get('NETWORK_CATEGORY_NAME'));
        $network->setId(Registry::get('NETWORK_CATEGORY_ID'));
        $network->setRessourceId(Registry::get('NETWORK_CATEGORY_RESSOURCE_ID'));
        return ($network);
    }

    private function generateRouteCategory()
    {
        $route = new DefaultCategory();

        $route->setName(Registry::get('ROUTE_CATEGORY_NAME'));
        $route->setRessourceId(Registry::get('ROUTE_CATEGORY_RESSOURCE_ID'));
        $route->setId(Registry::get('ROUTE_CATEGORY_ID'));
        return ($route);
    }

    protected function getConfiguration()
    {
        return (array(
            'name' => 'Divia',
            'storage' => array(
                'type' => 'filesystem',
                'path' => '/tmp/MediaManager/',
            ),
            'strategy' => 'CanalTP\MediaManager\Strategy\DefaultStrategy'
        ));
    }

    public function setUp()
    {
        $this->company = new Company();
        $configurationBuilder = new ConfigurationBuilder();
        $mediaBuilder = new MediaBuilder();
        $this->category = $this->generateRouteCategory();

        $this->company->setConfiguration(
            $configurationBuilder->buildConfiguration($this->getConfiguration())
        );
        $this->category->setParent($this->generateNetworkCategory());
        $this->media = $mediaBuilder->buildMedia(
            Registry::get('/') . Registry::get('SOUND_FILE'),
            $this->company,
            $this->category
        );
        $this->company->setName('Divia');
        $this->company->addMedia($this->media);
    }

    private function deleteDirRecursively($path)
    {
        foreach (glob($path . '/*') as $subPath) {
            $this->deleteDirRecursively($subPath);
        }
        rmdir($path);
    }

    public function tearDown()
    {
        $path = $this->company->getStorage()->getPath();

        $this->deleteDirRecursively($path);
        parent::tearDown();
    }
}

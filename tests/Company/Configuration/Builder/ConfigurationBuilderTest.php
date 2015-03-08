<?php

namespace CanalTP\MediaManager\Test\Company\Configuration\Builder;

use CanalTP\MediaManager\Registry;
use CanalTP\MediaManager\Test\AbstractTest;
use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilder;

class ConfigurationBuilderTest extends AbstractTest
{
    private $builder = null;
    private $params = null;

    public function setUp()
    {
        $this->params = $this->getConfiguration();
        $this->builder = new ConfigurationBuilder();
    }

    public function testBuildConfiguration()
    {
        $configuration = $this->builder->buildConfiguration($this->params);

        $this->params['strategy'] = Registry::get('NAVITIA_STRATEGY_NAME');
        $configuration = $this->builder->buildConfiguration($this->params);
    }

    public function testGetConfiguration()
    {
        $configuration = $this->builder->buildConfiguration($this->params);
        $this->assertInstanceOf(
            Registry::get('CONFIGURATION_INTERFACE'),
            $configuration,
            Registry::get('BAD_RETURN')
        );
    }

    public function tearDown()
    {
    }
}

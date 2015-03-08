<?php

require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/Registry.php';

use CanalTP\MediaManager\Registry;

$folder = __DIR__.'/../tests/data/registry/';
Registry::addByFile($folder . 'strings.ini');
Registry::addByFile($folder . 'messages.ini');
Registry::addByFile($folder . 'types.ini');
Registry::add('/', __DIR__ . '/');

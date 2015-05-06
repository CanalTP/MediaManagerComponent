<?php
namespace CanalTP\MediaManager\Test\Media;

use CanalTP\MediaManager\Media\GenericMedia;
use CanalTP\MediaManager\Media\CanalTP\MediaManager\Media;
use CanalTP\MediaManager\Media\MediaType;

class GenericMediaTest extends \PHPUnit_Framework_TestCase
{
	public function testMediaTypeIsValidForGenericMedia()
	{
		$genericMedia = new GenericMedia();
		$this->assertEquals(MediaType::UNKNOWN, $genericMedia->getMediaType()); 
	}
}
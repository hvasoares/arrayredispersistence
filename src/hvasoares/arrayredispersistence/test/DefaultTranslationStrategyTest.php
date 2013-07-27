<?php
namespace hvasoares\modelmapping;
require_once 'DefaultTranslationStrategy.php';
class DefaultTranslationStrategyTest extends \PHPUnit_Framework_Testcase{
	public function testShouldNotSaveTransient(){
		$instance = new DefaultTranslationStrategy();
		$this->assertFalse($instance->shouldSave(
			'attr_transient'
		));

		$this->assertTrue($instance->shouldSave(
			'attr'
		));

	}

	public function testShouldLoadEverything(){
		$instance = new DefaultTranslationStrategy();
		$this->assertTrue($instance->shouldLoad(null));
	}

	public function testMappingReturnItSelf(){
		$instance = new DefaultTranslationStrategy();
		$this->assertEquals(
			array(
				$instance->arrayToProperty(1),
				$instance->propertyToArray(2)
			),
			array(1,2)
		);
	}
}
?>

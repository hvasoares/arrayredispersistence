<?php
namespace hvasoares\arrayredispersistence;
require 'ModelToArrayTransforming.php';
use \Mockery as m;
class ModelToArrayTransformingTest extends \PHPUnit_Framework_Testcase{
	public function testShouldReadAnObjectPropertiesAndReadItAll(){
		$modelInstance = new \stdClass;

		$ts = m::mock('TranslationStrategy');
		$reflectionMock = m::mock('\ReflectionObject');
		$reflectionMock->shouldReceive('getProperties')
			->andReturn($this->createProperties(
			$modelInstance,
			$ts,
			array(
				'shouldBeContained' =>'v1',
				'shouldBeContained2'=>'v2',
				'shouldNot_transient'=>'v3'
			)
		))
		->times(1);

		$instance = new ModelToArrayTransforming($ts);


		$this->assertEquals(
			array(
				'shouldBeContained' =>'v1',
				'shouldBeContained2' =>'v2'
			),
			$instance->getModelArray(
				$modelInstance,
				$reflectionMock
			)
		);
	}

	public function testShouldWriteAnObject(){
		
	}

	private function createProperties($instance,$ts,$properties){
		$result = array();
		foreach($properties as $prop=>$val){
			$result [] = 
				$this->accessiblePropertyBehaviour(
					$prop,$instance,$val
				);
			$this->accessibleStrategy($ts,$prop);
		}
		return $result;
	}

	private function accessiblePropertyBehaviour($p,$inst,$val){
		$r = m::mock("ReflectionProperty_$p");
		$r->shouldReceive('getName')
			->andReturn($p)
			->atLeast(1);
		if(preg_match('/_transient$/',$p))
			return $r;
		$r->shouldReceive('setAccessible')
			->with(true)
			->times(1);
		$r->shouldReceive('getValue')
			->with($inst)->andReturn($val);
		return $r;
	}
	private function accessibleStrategy($ts,$prop){
		$transient = preg_match('/_transient$/',$prop);

		$ts->shouldReceive('shouldSave')
			->with($prop)
			->andReturn($transient?false:true)
			->times(1);
		$ts->shouldReceive('propertyToArray')
			->with($prop)
			->andReturn($prop)
			->times($transient?0:1);

	}
}
?>


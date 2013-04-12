<?php
namespace switch5\modelmapping;

require 'ArrayToModelTransforming.php';
use \Mockery as m;
class ArrayToModelTransformingTest extends \PHPUnit_Framework_Testcase{
	public function testGivenArrayShouldSetModelProperties(){
		$model = 'model';	
		$ts = m::mock('translationStrategy');

		$instance = new ArrayToModelTransforming($ts);

		$ts->shouldReceive('shouldLoad')
			->with('mustNotLoad')
			->andReturn(false)
			->times(1);
		$ts->shouldReceive('shouldLoad')
			->with('mustLoad')
			->andReturn(true)
			->times(1);
		$ts->shouldReceive('arrayToProperty')
			->with('mustLoad')
			->andReturn('mustLoad_translated')
			->times(2);
		$ts->shouldReceive('arrayToProperty')
			->with('mustNotLoad')
			->andReturn(null)
			->times(1);


		$rfo = m::mock('reflectionobj');
		$rfo->shouldReceive('hasProperty')
			->with('mustLoad_translated')
			->andReturn(true)
			->times(1);
		$rfo->shouldReceive('hasProperty')
			->with(null)
			->andReturn(true)
			->times(1);

		$prop = m::mock('propreflect');
		$rfo->shouldReceive('getProperty')
			->with('mustLoad_translated')
			->andReturn($prop)
			->times(1);
		$prop->shouldReceive('setAccessible')
			->with(true)
			->times(1);
		$prop->shouldReceive('setValue')
			->with($model,'loadval')
			->times(1);

		$instance->arrayToModel(
			array(
				'mustLoad' =>'loadval',
				'mustNotLoad' => 'val'
			),
			$model,
			$rfo
		);
	}
	
}
?>

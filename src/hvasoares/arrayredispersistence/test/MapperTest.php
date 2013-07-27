<?php
namespace hvasoares\modelmapping;
require_once 'Mapper.php';
use \Mockery as m;
class MapperTest extends \PHPUnit_Framework_Testcase{
	public function testShouldUseModelToDb(){
	

		$model = new Mapper(null,null);
		$bm = m::mock('bdtomodel');
		$mb = m::mock('modeltodb');

		$inst = new Mapper($bm,$mb);
		$mb->shouldReceive('getModelArray')
			->with($model,m::type('\ReflectionObject'))
			->andReturn('an_array')
			->times(1);

		$this->assertEquals(
			$inst->getArray($model),'an_array'
		);
	}

	public function testShouldUseBdToModel(){
		$model = new Mapper(null,null);
		$bm = m::mock('bdtomodel');
		$mb = m::mock('modeltodb');

		$inst = new Mapper($bm,$mb);
		$bm->shouldReceive('arrayToModel')
			->with('an_array',$model,m::type('\ReflectionObject'))
			->andReturn($model)
			->times(1);

		$this->assertEquals(
			$inst->arrayToModel($model,'an_array'),$model
		);

	}
}
?>

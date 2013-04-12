<?php
namespace switch5\modelmapping;
require 'Repository.php';
use \Mockery as m;
class RepositoryTest extends \PHPUnit_Framework_Testcase{
	public function testShouldSaveMappingToAModel(){
		$model = m::mock('model');
		$mapper = m::mock('mapper');


		$model->shouldReceive('save')
			->with('mapper_result')
			->times(1);
		$mapper->shouldReceive('getArray')
			->with('anyObj')
			->andReturn('mapper_result')
			->times(1);

		$inst = $this->createInstance($model,$mapper,m::mock('strategy'));

		$inst->save('anyObj');
	}	
	private function createInstance($model,$mapper,$sm){
		$inst = new Repository(array(
			'Model'=>$model,
			'Mapper'=>$mapper
		));

		$sm->shouldReceive('getSchemaClosure')
			->andReturn('anschema')
			->times(1);

		$model->shouldReceive('setSchema')
			->with('anschema')
			->times(1);
		$inst->setStrategy($sm);
		return $inst;
	}
	public function testFind(){
		$model = m::mock('model');
		$mapper = m::mock('mapper');
		
		$sm = m::mock('strategy');
		$sm->shouldReceive('createNewModel')
			->andReturn(
				'newObject'
			)
			->times(1);

		$model->shouldReceive('find')
			->with(1)
			->andReturn('bd_result')
			->times(1);
		$mapper->shouldReceive('arrayToModel')
			->with('newObject','bd_result')
			->andReturn('mapper_result')
			->times(1);

		$inst = $this->createInstance($model,$mapper,$sm);
		$inst->setStrategy($sm);
		$inst->find(1);

	}
}
?>

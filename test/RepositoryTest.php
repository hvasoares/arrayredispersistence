<?php
namespace switch5\modelmapping;
require 'Repository.php';
use \Mockery as m;
class RepositoryTest extends \PHPUnit_Framework_Testcase{
	public function testShouldSaveMappingToAModel(){
		$model = m::mock('model');
		$mapper = m::mock('mapper');
		$mapperResultArray = array();
		$anyObj = $this->createDomainObj($model,null);
		$model->shouldReceive('persists')
			->with(array())
			->andReturn('new_id')
			->times(1);
		$mapper->shouldReceive('getArray')
			->with($anyObj)
			->andReturn(array())
			->times(1);
		$mapper->shouldReceive('arrayToModel')
			->with($anyObj,array('id'=>'new_id'))
			->times(1);
		$sm =m::mock('strategy1');
		$this->createInstance(
				$model,
				$mapper,
				$sm
		)->save($anyObj);
	}	
	private function createInstance($model,$mapper,$sm){
		$inst = new Repository(array(
			'Model'=>$model,
			'Mapper'=>$mapper
		));

		$sm->shouldReceive('getSchemaClosure')
			->andReturn('anschema')
			->atLeast(1);

		$model->shouldReceive('setSchema')
			->with('anschema')
			->atLeast(1);
		$inst->setStrategy($sm);
		return $inst;
	}

	public function createDomainObj($model,$id=null){
		$anyObj = m::mock('obj');
		$anyObj->shouldReceive('id')
			->andReturn($id)
			->times($id?2:1);
		if($id)
			$this->modelFind($model,$id);
		else
			$model->shouldReceive('newOne')
				->times(1);
		return $anyObj;
	
	}

	private function modelFind($model,$id){
		$model->shouldReceive('find')
			->with($id)
			->andReturn('bd_result')
			->times(1);
	
	}
	private function findBehaviour($id,$model,$mapper,$sm,$inst=null){
		$sm->shouldReceive('createNewModel')
			->andReturn(
				'newObject'
			)
			->times(1);
		$this->modelFind($model,$id);
		$mapper->shouldReceive('arrayToModel')
			->with('newObject','bd_result')
			->andReturn('mapper_result')
			->times(1);
		if(!$inst)
			$inst = $this->createInstance($model,$mapper,$sm);
		return $inst;
	}
	public function testFind(){
		$inst = $this->findBehaviour(1,m::mock('model'),m::mock('mapper'),m::mock('strategy'));
		$inst->find(1);
	}
}
?>

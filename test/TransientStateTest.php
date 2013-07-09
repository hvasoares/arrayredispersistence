<?php
namespace hvasoares\arrayredispersistence;
require_once 'TransientState.php';
require_once 'InstantiatedSchema.php';
use \Mockery as m;
class TransientStateTest extends \PHPUnit_Framework_Testcase{
	public function testShouldPassRawDataToPersistence(){
		$instance =$this->baseGiven(m::mock('model'),$id=1);
		$instance->resolve_call('persists',array('values'));
	}
	private function baseGiven($m,$id){
		$si = m::mock("hvasoares\arrayredispersistence\InstantiatedSchema");
		$si->shouldReceive('setAttrs')
			->with('values')
			->times(1);
		$si->shouldReceive('getId')
			->andReturn($id)
			->times($id?2:1);
		$si->shouldReceive('toArray')
			->andReturn('rawmodel')
			->times(1);
		if($id)
			$si->shouldReceive('setId')
				->with($id)
				->times(1);
		else{
			$si->shouldReceive('setId')
				->with('incrementedKey')
				->times(1);
			$si->shouldReceive('getIncKey')
				->andReturn('akey')
				->times(1);
		}

		$instance = new TransientState($si);
		$p = m::mock('Persistence');

		$instance->setPersistence($p);

		$p->shouldReceive('persists')
			->with('rawmodel')
			->times(1);

		$instance->setModel($m);
		return $instance;
	}
	public function testGeneratingANewId(){
		$m = m::mock('modelm');
		$instance =$this->baseGiven($m,$id=null);
		
		$r = m::mock('redism');
		
		$r->shouldReceive('incr')
			->with('akey')
			->andReturn('incrementedKey')
			->times(1);
		$m->shouldReceive('getRedis')
			->andReturn($r)
			->times(1);
		$instance->resolve_call('persists',array('values'));
	}
}
?>

<?php
namespace switch5php\model;
require_once 'TransientState.php';
use \Mockery as m;
class TransientStateTest extends \PHPUnit_Framework_Testcase{
	public function testShouldPassRawDataToPersistence(){
		$si = m::mock('InstatiatedSchema');

		$si->shouldReceive('getId')
			->andReturn('a_id')
			->times(2);
		$si->shouldReceive('toArray')
			->andReturn('rawmodel')
			->times(1);
		$si->shouldReceive('setId')
			->with('a_id')
			->times(1);

		$instance = new TransientState($si);
		$p = m::mock('Persistence');

		$instance->setPersistence($p);

		$p->shouldReceive('persists')
			->with('rawmodel')
			->times(1);
		
		$m = m::mock('modelm');
		$r = m::mock('redism');
		
		$instance->setModel($m);
		$instance->resolve_call('persists',null);
	}
	public function testGeneratingANewId(){
		$si = m::mock('InstatiatedSchema');

		$si->shouldReceive('getId')
			->andReturn(null)
			->times(1);
		$si->shouldReceive('toArray')
			->andReturn('rawmodel')
			->times(1);
		$si->shouldReceive('setId')
			->with('incrementedKey')
			->times(1);
		$si->shouldReceive('getIncKey')
			->andReturn('akey')
			->times(1);

		$instance = new TransientState($si);
		$p = m::mock('Persistence');

		$instance->setPersistence($p);

		$p->shouldReceive('persists')
			->with('rawmodel')
			->times(1);
		
		$m = m::mock('modelm');
		$r = m::mock('redism');
		
		$r->shouldReceive('incr')
			->with('akey')
			->andReturn('incrementedKey')
			->times(1);
		$m->shouldReceive('getRedis')
			->andReturn($r)
			->times(1);
		$instance->setModel($m);
		$instance->resolve_call('persists',null);
	}
}
?>

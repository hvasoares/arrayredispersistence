<?php
require_once 'SchemaSettedState.php';
use \Mockery as m;
class SchemaSettedStateTest extends PHPUnit_Framework_Testcase{
	public function testGivenASchemaShouldRetrieveFromRedis(){
		$s = mockSchema();
		$s->attrs = array(
			'attr1',
			'attr2'
		);
		$s->modelName = 'M1';
		$s->incrKey = 'M1Key';

		$m = m::mock('modelm');
		$r = m::mock('redism');
		$m->shouldReceive('getRedis')
			->andReturn($r)
			->times(1);
		$m->shouldReceive('setState')
			->with(m::type('TransientState'))
			->times(1);

		$instance = new SchemaSettedState($s);

		$instance->setModel($m);

		$r->shouldReceive('get')
			->with('M1Key')
			->andReturn(10)
			->times(1);
		$r->shouldReceive('get')
			->with('M1[1]attr1')
			->andReturn('val1')
			->times(1);

		$r->shouldReceive('get')
			->with('M1[1]attr2')
			->andReturn('val2')
			->times(1);

		$instance->resolve_call('find',array(1));

	}
}
?>

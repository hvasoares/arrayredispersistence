<?php
namespace switch5php\model;
require 'Model.php';

use \Mockery as m;

class ModelTest extends \PHPUnit_Framework_Testcase{
	public function testShouldBuildAModelFromAStrategy(){
		$r = m::mock('redism');
		$s = m::mock('state');

		$s->shouldReceive('resolve_call')
			->with('a_method',array(1,2))
			->andReturn('aresult')
			->times(1);

		$instance = new Model($r);

		$instance->setState($s);

		$this->assertEquals(
			$instance->a_method(1,2),
			'aresult'
		);
	}
}
?>
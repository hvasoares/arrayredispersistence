<?php
namespace switch5\modelmapping;
require_once 'ModelProxyState.php';
require_once 'ModelInterface.php';
use \Mockery as m;
class ModelProxyStateTest extends \PHPUnit_Framework_Testcase{
	public function testShouldProcessStatesBeforeSettedInModel(){
		$m = m::mock('ModelInterface');
		$assert = $this;
		$new_state = m::mock('state');
		$fn = function($state) use($assert,$new_state){
			$assert->assertEquals($state,$new_state);
			return 'modified_state';
		};

		$instance = new ModelProxyState($m,$fn);
		$new_state->shouldReceive('setModel')
			->with($instance)
			->times(1);


		$m->shouldReceive('setState')
			->with('modified_state')
			->times(1);
		$instance->setState($new_state);
	}
}
?>

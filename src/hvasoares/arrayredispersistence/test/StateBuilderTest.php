<?php
namespace hvasoares\arrayredispersistence;
require_once 'StateBuilder.php';
use \Mockery as m;
class StateBuilderTest extends \PHPUnit_Framework_Testcase{
	public function testShouldConfigureTransientState(){
		$instance = new StateBuilder(array(
			'Persistence' => 'p'
		));
		$transientState = m::mock(
			'hvasoares\arrayredispersistence\TransientState'
		);	
		$transientState->shouldReceive('setPersistence')
			->with('p')
			->times(1);
		$instance->build($transientState);
	}
}
?>

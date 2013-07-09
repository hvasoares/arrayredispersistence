<?php
namespace hvasoares\modelmapping;
require_once 'StateBuilder.php';
use \Mockery as m;
class StateBuilderTest extends \PHPUnit_Framework_Testcase{
	public function testShouldConfigureTransientState(){
		$instance = new StateBuilder(array(
			'Persistence' => 'p'
		));
		$transientState = m::mock(
			'hvasoares\modelmapping\TransientState'
		);	
		$transientState->shouldReceive('setPersistence')
			->with('p')
			->times(1);
		$instance->build($transientState);
	}
}
?>

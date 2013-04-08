<?php
require_once 'Persistence.php';
use \Mockery as m;
class PersistenceTest extends PHPUnit_Framework_Testcase{
	public function testShouldPersistsRawData(){
		$r = m::mock('redism');
		$instance = new Persistence($r);

		$r->shouldReceive('set')
			->with('attr1','val1')
			->times(1);
		$r->shouldReceive('set')
			->with('attr2','val2')
			->times(1);

		$instance->persists(
			array(
				'attr1'=>'val1',
				'attr2'=>'val2'
			)
		);

	}
}
?>

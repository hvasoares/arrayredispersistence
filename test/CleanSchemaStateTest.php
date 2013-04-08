<?php
namespace switch5php\model;
require 'CleanSchemaState.php';
use \Mockery as m;

class CleanSchemaStateTest extends \PHPUnit_Framework_Testcase{
	public function testShouldAddMethodToModel(){
		$instance = new CleanSchemaState();
		$model = m::mock('modelM');

		$instance->setModel($model);

		$model->shouldReceive('setState')
			->with(m::type('switch5php\model\SchemaSettedState'))
			->times(1);

		$assert = $this;

		$instance->resolve_call(
			'setStrategy',
			array(
			function($m) use($assert,$instance){
				$assert->assertEquals($m,$instance);	
				$calls = array(
					'incrKey' => 'incrKey1',
					'attr' => 'attr1',
					'modelName' => 'amodel',
					'setValidationClosure'=> function($v){}
				);

				foreach($calls as $method=>$arg)
					$instance->resolve_call(
						$method,array($arg)
					);			
			})
		);

		$schema = $instance->getSchema();
		$this->assertEquals(
			$schema->incrKey, 'incrKey1'
		);
		$this->assertEquals(
			$schema->modelName, 'amodel'
		);
		$this->assertTrue(is_array($schema->attrs));
		$this->assertEquals(
			$schema->attrs,array('attr1')
		);
	}
}

?>

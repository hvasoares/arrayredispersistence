<?php
namespace switch5\modelmapping;
require 'InstantiatedSchema.php';
class InstantiatedSchemaTest extends \PHPUnit_Framework_Testcase{
	public function testShouldGetRawArrayAndApplyToIt(){
		$instance = new InstantiatedSchema(
			mockSchema(),
			array_combine(
				mockSchema()->attrs,
				array('v1','v2')
			)
		);

		$instance->setId('aid');
		$this->assertEquals(
			$instance->toArray(),
			array(
				'modelname[aid]attr1'=>'v1',
				'modelname[aid]attr2'=>'v2',
			)
		);
	}
	
}
?>

<?php
set_include_path(
    dirname(__FILE__) . '/../../library'
	        . PATH_SEPARATOR . get_include_path()
	);

require_once 'Mockery/Loader.php';

$loader = new \Mockery\Loader;
$loader->register();

function mockSchema(){
	$r = new stdClass;
	$r->modelName='modelname';
	$r->incrKey='modelkey';
	$r->attrs = array('attr1','attr2');
	$r->validationClosure = function($id){
		return true;
	};
	return $r;
}

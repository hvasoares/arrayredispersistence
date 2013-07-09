<?php
require_once 'GlueCode.php';
use hvasoares\commom\Registry;
use hvasoares\arrayredispersistence\GlueCode;
$registry = new Registry();
$registry['Redis'] = new Redis();
$registry['Redis']->connect("127.0.0.1");

$gc = new GlueCode();
$r = $gc->getRegistry($registry);

class Model{
	public $id,$attr1_transient,$attr2;
	public function id(){
		return $this->id;
	}	
}

class Strategy{
	public function createNewModel(){
		return new Model();
	}

	public function getSchemaClosure(){
		$val = function($raw){
			return true;
		};
		return function($m) use($val){
			$m->modelName('Model');
			$m->attr('attr2');
				$m->incrKey('modelIncr');
				$m->setValidationClosure($val);
		};
	}
}

$repo = $r['Repository'];
$repo->setStrategy(new Strategy);

$m = new Model();

$m->attr2 = 'm1';

$repo->save($m);
echo $m->id()."####".$m->attr2;

$m =$repo->find($m->id());
echo $m->id()."####".$m->attr2;
$m->attr2='m2';
$repo->save($m);
echo $m->id()."####".$m->attr2;

?>

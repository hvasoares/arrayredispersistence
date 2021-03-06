<?php
namespace hvasoares\arrayredispersistence;
require_once 'SchemaSettedState.php';
class CleanSchemaState{
	public function __construct(){
		$this->schema = new \stdClass;
		$this->schema->attrs[]='id';
	}
	public function setModel($model){$this->model = $model;}
	private function incrKey($value){
		$this->schema->incrKey 	= $value;
		return $this->model;
	}

	private function attr($value){
		$this->schema->attrs[]=$value;
		return $this->model;
	}

	private function modelName($value){
		$this->schema->modelName = $value;
		return $this->model;
	}

	private function setValidationClosure($val){
		$this->schema->validationClosure = $val;
		return $this->model;
	}

	private function setSchema(\Closure $fn){
		$fn($this->model);
		$this->model->setState(new SchemaSettedState(
			$this->getSchema()
		));
	}

	public function resolve_call($method,$args){
		$this->$method($args[0]);
	}
	public function getSchema(){return $this->schema;}
}?>

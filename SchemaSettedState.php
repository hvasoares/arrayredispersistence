<?php
namespace switch5\modelmapping;
require_once __DIR__.'/validations.php';
require_once 'TransientState.php';
require_once 'InstantiatedSchema.php';
use \switch5\validations as v;
class SchemaSettedState{
	public function __construct($schema){
		$this->schema = v\returnIfIsSchema($schema);
	}
	private function find($id){
		$idex = v\isArrayAndReturnValue($id,0);
		$s = $this->schema;
		$r =$this->model->getRedis();
		$nowidex = $r->get($s->incrKey);
		if($nowidex < $idex)
			throw new Exception(
				"The number $idex is greater than the model key '{$s->incrKey}'=$nowidex"
			);


		foreach($s->attrs as $attr){
			$attrname = $s->modelName;
			$attrname.="[$idex]$attr";
			$result[$attr] = ($r->get(
				v\isString($attrname))
			);
		}

		$result["id"]=strval($idex);
		$this->model->setState(new TransientState(
			new InstantiatedSchema($s,$result)
		));
		return v\returnIfMatchSchema($s,$result);
	}
	private function newOne(){
		$this->model->setState(new TransientState(new InstantiatedSchema($this->schema)));
	}
	public function setModel($val){$this->model = $val;}
	public function resolve_call($m,$val){return $this->$m($val);}
}
?>

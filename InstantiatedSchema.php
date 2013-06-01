<?php
namespace switch5\modelmapping;
require_once 'validations.php';
use \switch5\validations as v;
class InstantiatedSchema{
	private $id;
	public function __construct($schema,$rawModel=null){
		$this->schema = v\returnIfIsSchema($schema);
		$this->attrs = v\returnSecondIfNull(
			v\returnIfMatchSchema($schema,$rawModel),
			array_fill_keys($schema->attrs,null)
		);
		if(array_key_exists('id',$this->attrs))
			$this->setId($this->attrs['id']);
	}

	public function setId($val){$this->id = $val;}
	public function getId(){return $this->id;}
	public function getIncKey(){return $this->schema->incrKey;}
	public function setAttrs($val){$this->attrs=$val;}
	public function toArray(){
		$model = $this->schema->modelName;
		$attrs = $this->attrs;
		$id = $this->getId();
		unset($attrs['id']);
		$result = array();
		foreach($this->schema->attrs as $sattr){
			$key = "$model"."[".$id."]$sattr";
			$result[$key] = $this->attrs[$sattr];
	
		}
		return $result;	
	}
}
?>

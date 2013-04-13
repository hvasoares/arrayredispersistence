<?php
namespace switch5\modelmapping;
require_once 'CleanSchemaState.php';
class Model{
	public function __construct($redis){
		$this->r = $redis;
	}
	public function getRedis(){
		return $this->r;
	}
	public function setState($val){
		$this->state=$val;
	}
	public function setRedisConnection($r){
		$this->r = $r;
	}	
	public function getState(){
		return $this->state;
	}

	public function __call($method,$args){
		return $this->state->resolve_call($method,$args);
	}

}
?>

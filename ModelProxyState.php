<?php
namespace switch5\modelmapping;
require 'ModelInterface.php';
class ModelProxyState implements ModelInterface{
	public function __construct($innerModel,$stateClosure){
		$this->m = $innerModel;
		$this->closure = $stateClosure;
	}
	public function setRedisConnection($redis){
		$this->m->setRedisConnection($redis);
	}	

	public function setState($newState){
		$fn = $this->closure;
		$newState->setModel($this);
		$this->m->setState($fn($newState));
	}

	public function getRedis(){
		return	$this->m->getRedis();	
	}

	public function __call($method,$call){
		return $this->m->__call($method,$call);	
	}

	public function getState(){
		return $this->m->getState();
	}

}
?>

<?php
require_once 'validations.php';
use \switch5\validations as v;
class Persistence{
	public function __construct($r){
		$this->r =$r;
	}
	public function persists($rawData){
		foreach(v\isArray($rawData) as $a=>$v)
			$this->r->set($a,$v);
	}		
}
?>

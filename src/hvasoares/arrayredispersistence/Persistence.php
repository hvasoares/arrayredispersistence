<?php
namespace hvasoares\arrayredispersistence;
require_once 'validations.php';
use \hvasoares\validations as v;
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

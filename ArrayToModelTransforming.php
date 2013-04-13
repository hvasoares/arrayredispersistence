<?php namespace switch5\modelmapping;
require_once 'validations.php';
use switch5\validations as v;
class ArrayToModelTransforming{
	public function __construct($translationStrategy){
		$this->ts = $translationStrategy;
	}

	public function arrayToModel($mArray,$model,$reflectionObject){
		$rf = $reflectionObject;
		foreach(v\isArray($mArray) as $key=>$val){
			if($this->keyIsLoadableProperty($rf,$key)){
				$this->setValue(
					$model,
					$reflectionObject->getProperty($this->ts->arrayToProperty($key)),
					v\isString(print_r($val,true))
				);
			}	
		}		
		return $model;
	}

	private function setValue($model,$prop,$val){
		$prop->setAccessible(true);
		$prop->setValue($model,$val);
	}

	private function keyIsLoadableProperty($rf,$key){
		$objHasKey =$rf->hasProperty(
			$this->ts->arrayToProperty($key)
		);
		return $this->ts->shouldLoad($key) && $objHasKey;
	}
}
?>

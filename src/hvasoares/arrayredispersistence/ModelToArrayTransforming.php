<?php
namespace hvasoares\modelmapping;
require_once 'TranslationStrategy.php';
class ModelToArrayTransforming{
	public function __construct($translationStrategy){
		$this->ts = $translationStrategy;
	}

	public function getModelArray($model,$reflection){
		$result = array();
		foreach($reflection->getProperties() as $prop){
			if($this->ts->shouldSave($prop->getName())){
				$prop->setAccessible(true);
				$result[$this->ts->propertyToArray(
					$prop->getName())
				] =$prop->getValue($model);
			}
		}
		return $result;
	}
}
?>

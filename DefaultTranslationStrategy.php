<?php
namespace hvasoares\modelmapping;
require_once 'TranslationStrategy.php';
class DefaultTranslationStrategy implements TranslationStrategy{
	public function shouldSave($attr){
		if(preg_match('/_transient$/',$attr))
			return false;
		return true;
	}

	public function shouldLoad($key){
		return true;
	}

	public function arrayToProperty($key){
		return $key;
	}
	public function propertyToArray($property){
		return $property;
	}
}
?>

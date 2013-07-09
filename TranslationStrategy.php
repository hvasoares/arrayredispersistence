<?php
namespace hvasoares\modelmapping;
interface TranslationStrategy{
	public function shouldSave($propertyName);
	public function propertyToArray($propertyName);
	public function arrayToProperty($arrayKey);
	public function shouldLoad($key);
}

?>

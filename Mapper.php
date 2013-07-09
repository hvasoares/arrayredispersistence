<?php
namespace hvasoares\modelmapping;
class Mapper{
	public function __construct($bdToModel,$modelToDb){
		$this->bm = $bdToModel;
		$this->mb = $modelToDb;
	}

	public function getArray($model){
		return $this->mb->getModelArray(
			$model,
			new \ReflectionObject($model)
		);
	}

	public function arrayToModel($modelDest,$arrayContents){
		return $this->bm->arrayToModel(
			$arrayContents,
			$modelDest,
			new \ReflectionObject($modelDest)
		);
	}
}
?>

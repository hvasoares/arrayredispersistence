<?php
namespace switch5\modelmapping;
class Repository{
	public function __construct($registry){
		$this->r = $registry;
	}
	public function setStrategy($val){
		$this->s=$val;
	}
	public function find($id){
		return	$this->r['Mapper']->arrayToModel(
			$this->s->createNewModel(),
			$this->getModel()->find($id)
		);
	}

	public function save($obj){
		$this->getModel()->save(
			$this->r['Mapper']->getArray($obj)
		);
	}

	private function getModel(){
		$model = $this->r['Model'];
		$model->setSchema($this->s->getSchemaClosure());	
		return $model;
	}
}
?>

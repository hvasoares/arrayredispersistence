<?php
namespace switch5\modelmapping;
class Repository{
	public function __construct($registry){
		$this->r = $registry;
	}
	public function setStrategy($val){
		$this->s=$val;
		$this->getModel();
	}
	public function find($id){
		return	$this->findInto($id,$this->s->createNewModel());
	}

	private function findInto($id,$destObj){
		return $this->r['Mapper']->arrayToModel(
			$destObj,
			$this->getModel()->find($id)
		);
	}

	public function save($obj){
		$m = $this->getModel();
		if($obj->id())
			$m->find($obj->id());
		else
			$m->newOne();
		$objArray =$this->r['Mapper']->getArray($obj);
		$id = $m->persists($objArray);
		$objArray['id']=$id;
		$this->r['Mapper']->arrayToModel($obj,$objArray);
	}

	private function getModel(){
		$model = $this->r['Model'];
		$model->setSchema($this->s->getSchemaClosure());	
		return $model;
	}
}
?>

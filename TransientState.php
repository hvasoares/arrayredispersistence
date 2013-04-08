<?
namespace switch5php\model;
require_once 'validations.php';
use \switch5\validations as v;
class TransientState{
	public function __construct($schemaInstantiated){
		$this->schemaI = $schemaInstantiated;
	}
	public function setModel($val){
		$this->model=$val;
	}
	public function setPersistence($val){
		$this->p = $val;
	}
	private function persists(){
		$id = is_null($this->schemaI->getId()) ?
			$this->model->getRedis()->incr(
				$this->schemaI->getIncKey()
			) :
			$this->schemaI->getId();
		$this->schemaI->setId($id);
		$this->p->persists($this->schemaI->toArray());
	}

	public function resolve_call($persistMethod,$val=null){
		v\mustBeEqual($persistMethod,"persists");
		$this->persists();
	}
}
?>

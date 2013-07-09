<?
namespace hvasoares\arrayredispersistence;
require_once 'validations.php';
require_once 'InstantiatedSchema.php';
use \hvasoares\validations as v;
class TransientState{
	public function __construct(InstantiatedSchema $is){
		$this->schemaI = $is;
	}
	public function setModel($val){
		$this->model=$val;
	}
	public function setPersistence($val){
		$this->p = $val;
	}
	private function persists($attrs){
		$this->schemaI->setAttrs($attrs);
		$id = is_null($this->schemaI->getId()) ?
			$this->model->getRedis()->incr(
				$this->schemaI->getIncKey()
			) :
			$this->schemaI->getId();
		$this->schemaI->setId($id);
		$this->p->persists($this->schemaI->toArray());
		return $id;
	}

	public function resolve_call($persistMethod,$val){
		v\mustBeEqual($persistMethod,"persists");
		return $this->persists($val[0]);
	}
}
?>

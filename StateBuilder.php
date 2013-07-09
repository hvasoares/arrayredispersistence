<?php
namespace hvasoares\arrayredispersistence;
require_once 'TransientState.php';
class StateBuilder{
	public function __construct($registry){
		$this->r = $registry;
	}
	public function build($state){
		if($state instanceof TransientState)
			$state->setPersistence(
				$this->r['Persistence']
			);
		return $state;
	}	
}
?>

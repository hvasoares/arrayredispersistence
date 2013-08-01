<?php
namespace hvasoares\arrayredispersistence;
use hvasoares\commons\Registry;
class GlueCode{
	public function getRegistry($top=null){
		$reg = new Registry($top);

		$reg['Repository'] = function($r){
			return new Repository($r);
		};


		$reg['FirstModelState']=function($r){
			return new CleanSchemaState();
		};

		$reg['StateBuilder'] = new StateBuilder($reg);
		$reg['Persistence'] = new Persistence($reg['Redis']);

		$reg['Model'] = function($r){
			$m = new ModelProxyState(
				new Model($r['Redis']),
				function($state) use ($r){
					return $r['StateBuilder']->build($state);
				}
			);
			$m->setState($r['FirstModelState']);
			return $m;
		};


		$sm = new DefaultTranslationStrategy();

		$reg['Mapper'] = new Mapper(
			new ArrayToModelTransforming($sm),
			new ModelToArrayTransforming($sm)
		);

		return $reg;
	}
}
?>


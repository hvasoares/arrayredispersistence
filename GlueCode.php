<?php
namespace switch5\modelmapping;

require_once 'TranslationStrategy.php';
require_once 'ArrayToModelTransforming.php';
require_once 'CleanSchemaState.php';
require_once 'DefaultTranslationStrategy.php';
require_once 'InstantiatedSchema.php';
require_once 'Mapper.php';
require_once 'Model.php';
require_once 'ModelToArrayTransforming.php';
require_once 'Persistence.php';
require_once 'Repository.php';
require_once 'SchemaSettedState.php';
require_once 'TransientState.php';
require_once 'StateBuilder.php';
require_once 'ModelProxyState.php';
if(!class_exists('switch5\commom\Registry'))
	require_once '../commom/Registry.php';
use switch5\commom\Registry;
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


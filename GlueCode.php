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

require_once 'libs/commons/Registry.php';
use switch5\commom\Repository;
class GlueCode{
	public function getRegistry(){
		$reg = new Registry();

		$reg['Repository'] = function($r){
			return new Repository($r);
		};

		$reg['Model'] = function($r){
			return new Model();
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


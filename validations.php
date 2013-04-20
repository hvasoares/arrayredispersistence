<?
namespace switch5\validations;
require_once 'libs/validations/validations.php';

function returnIfMatchSchema($schema,$rawModel){
	if(!is_array($rawModel))
		return null;
	$fn = $schema->validationClosure;
	notFalse($fn(isArray($rawModel)));
	return $rawModel;
}


function returnIfIsSchema(&$schema){
	notNull($schema);
	isString($schema->incrKey);
	isString($schema->modelName);
	returnIfArrayWithSize(1,$schema->attrs);
	mustHaveArity(
		ofType('Closure',$schema->validationClosure),
		1
	);
	return $schema;

}


?>

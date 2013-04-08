<?
namespace switch5\validations;

class ValidationException{
	
}

function mustBeEqual($v1,$v2){
	if(notNull($v1)!=notNull($v2))
		throwError("$v1 != $v2");
}

function mustHaveArity($closure,$arity){
	$r = new \ReflectionObject(ofType('Closure',$closure));
	$m = $r->getMethod('__invoke');
	if(isInteger($arity) == $m->getNumberOfParameters())
		return $closure;
	throwError("The closure doesnt has arity equals $arity");
}

function notFalse($val){
	if($val)
		return $val;
	throwError("It should be false");
}

function ofType($type,$val){
	if($val instanceof $type)
		return $val;
	throwError("Not of type '$type'");
}

function returnIfMatchSchema($schema,$rawModel){
	$fn = $schema->validationClosure;
	notFalse($fn(isArray($rawModel)));
	return $rawModel;
}

function returnSecondIfNull($first,$second){
	if($first)
		return $first;
	return $second;
}


function throwError($msg){
	throw new \Exception($msg);
}
	
function notNull($val){
	if($val)
		return $val;
	throwError("Value is null");

}

function isInteger($val){
	if(is_int($val))
		return $val;
	throwError("Not a integer");
}

function isString($val){
	if(is_string(notNull($val)))
		return $val;
	throwError("Not a string");
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

function returnIfArrayWithSize($size,$array){
	if( sizeof(isArray($array)) >=$size )
		return $array;
	throw new Exception(
		"The array doesn't has $size items"
	);
}

function isArray($val){
	if(is_array($val))
		return $val;
	throwError("Not a array");
}

function isArrayAndReturnValue($val,$index){
	if(isArray($val) && array_key_exists($index,$val) )
		return $val[$index];
	throwError("The array doesn't has $index");
}

?>

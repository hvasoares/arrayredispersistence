<?php
class AClass{
	private $privateAttribute;
	public function privateAttribute(){
		return $this->privateAttribute;
	}
}

$a = new AClass();

$ar = new ReflectionObject($a);

foreach($ar->getProperties() as $p){
	echo $p->getName();
	$p->setAccessible(true);
	$p->setValue($a,'a value');
}

$ar->hasProperty(null);

echo $a->privateAttribute();
?>

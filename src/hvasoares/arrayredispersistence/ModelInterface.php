<?php
namespace hvasoares\arrayredispersistence;
interface ModelInterface{
	public function getRedis();
	public function setState($val);
	public function setRedisConnection($r);
	public function getState();
	public function __call($method,$args);
}
?>

<?php
/**
 * helper to retreive quickly a config value.
 */
function __config($group, $key,$default=""){
	return Config::getInstance()->get($group,$key,$default);
}
/**
 * helper to test a flag in the config file.
 */
function __isActive($group, $key){
	return Config::getInstance()->isActive($group,$key);
}
?>
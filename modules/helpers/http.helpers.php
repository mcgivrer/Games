<?php
/**
 * retrieve a value from requet and set this <code>$key</code> value into session or set default value(<code>$defaultValue</code>).
 * @param string $key
 * @param object $defaultvalue
 */
function __requestSession($key,$defaultValue,$cookie=null,$store=""){	
		return ToolsRequest::getInstance()->requestSession($key,$defaultValue,$cookie);
}
/**
 * retrieve a value from requet and set this <code>$key</code> value into session or set default value(<code>$defaultValue</code>).
 * @param string $key
 * @param object $defaultvalue
 */
function __parameterRequest($key,$defaultValue,$manager=null,$store=""){
		return ToolsRequest::getInstance()->parameterRequest($key,$defaultValue,$manager);
}
?>
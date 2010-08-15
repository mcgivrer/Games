<?php
/**
 * retrieve a value from requet and set this <code>$key</code> value into session or set default value(<code>$defaultValue</code>).
 * @param string $key
 * @param object $defaultvalue
 */
function __requestSession($key,$defaultValue){
	
		return ToolsRequest::getInstance()->requestSession($key,$defaultValue);
	/*
	// load key's value from Request, or from session, od set to defaut value.
	$value = (isset($_REQUEST["".$key])?$_REQUEST["".$key]:(isset($_SESSION["".$key])?$_SESSION["".$key]:$defaultValue));
	// store key's value into session.
	$_SESSION[$key]=$value;
	return $value;
	*/
}
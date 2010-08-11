<?php
/**
 * Set a key value into session from request or from default value.
 * @param string $key
 * @param object $defaultvalue
 */
function __requestSession($key,$defaultvalue){
	// load key's value from Request, or from session, od set to defaut value.
	$value = (isset($_REQUEST["".$key])?$_REQUEST["".$key]:(isset($_SESSION["".$key])?$_SESSION["".$key]:$defaultvalue));
	// store key's value into session.
	$_SESSION[$key]=$value;
	return $value;
}
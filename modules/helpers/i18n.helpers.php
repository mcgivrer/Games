<?php
/**
 * Find translated sentence for group/key into selected language.
 * @param String $group
 * @param String $key
 */
function __($group,$key){
	return I18n::getInstance()->get($group,$key);
}
/**
 * As __(), retreive translated sentence for group/key with parameters !
 * all {x} value will be replaced with corresponding args. 
 * @param $group
 * @param $key
 */
function __s($group,$key){
    $args = array_slice(func_get_args(),2);
	return I18n::getInstance()->getS($group,$key,$args);
}
/**
 * As __h(), retreive translated sentence for group/key with parameters and remove any HTML content
 * @param $group
 * @param $key
 */
function __h($group,$key){
	return I18n::getInstance()->removeHtml($group,$key);
}
?>
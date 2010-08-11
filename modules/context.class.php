<?php
/**
 * Context Container. Manage a bundle of attributes.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
 */
class Context{
	/**
	 * Attributes container
	 * @var array
	 */
	private $attributes = array();
	
	/**
	 * Add a couple key/value to the context
	 * @param $key
	 * @param $value
	 */
	public function set($key,$value){
		$this->attributes[$key]=$value;
	}
	
	/**
	 * Remove a key from context
	 * @param $key
	 */
	public function remove($key){
		$this->attributes[$key]=null;
	}
	
	/**
	 * return Context attribute value for <code>$key</code>.
	 * @param unknown_type $key
	 */
	public function get($key){
		return $this->attributes[$key];
	}
	
	/**
	 * Return all context attributes in an array.
	 */
	public function getAll(){
		return $this->attributes;
	}
}
?>
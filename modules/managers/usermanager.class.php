<?php
class UserManager extends ApplicationManager{
	/**
	 * Call parent constructorto initialize default system.
	 */
	public function __construct($name, $params){
		__debug("Start",__METHOD__,__CLASS__);
		parent::__construct($name,$params);
	}
	
	public function login(){
		return "master";
	}

	public function logout(){
		return "master";
	}
	
	public function edit(){
		return "master";
	}
	
	public function view(){
		return "master";
	}
	public function delete(){
		return "master";
	}
}
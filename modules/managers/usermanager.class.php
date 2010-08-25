<?php
class UserManager extends ApplicationManager{
	/**
	 * Call parent constructorto initialize default system.
	 */
	public function __construct($name, $params){
		__debug("Start",__METHOD__,__CLASS__);
		parent::__construct($name,$params);
	}
	/**
	 * Login an existing user.
	 */	
	public function login(){
		return "master";
	}

	/**
	 * Log out connected user.
	 */
	public function logout(){
		return "master";
	}

	/**
	 * Show register form.
	 */
	public function register(){
		return "register";
	}
		
	/**
	 * Edit user.
	 */
	public function edit(){
		return "edit";
	}
	
	/**
	 * Show personal details of the selected user.
	 */
	public function view(){
		return "view";
	}
	
	/**
	 * Delete selected user
	 */
	public function delete(){
		return "master";
	}
	
	/**
	 * Update to persistance selected user.
	 */
	public function update(){
		return "update";
	}
	
	/**
	 * create a new user and store to persistance.
	 */
	public function create(){
		return "save";
	}
}
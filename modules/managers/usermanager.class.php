<?php
class UserManager extends ApplicationManager{
	/**
	 * Call parent constructorto initialize default system.
	 */
	public function __construct($name, $params){
		__debug("Start",__METHOD__,__CLASS__);
		$this->addData('page-title',__config('user','page_title'));
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
		$name	= __parameterRequest('name',"admin",$this,"session");
		$user = $this->persistance->getUserByName($name);
		//echo "<pre>user=[".print_r($user[1],true)."]</pre>";
		$this->addData('user',$user[1]);
		$this->addData('page-title',I18n::getInstance()->getS('user','edit_title',$user[1]->name));
		return "edit";
	}
	
	/**
	 * Show personal details of the selected user.
	 */
	public function view(){
		$name	= __parameterRequest('name',"admin",$this,"session");
		$user = $this->persistance->getUserByName($name);
		echo "<pre>user=[".print_r($user[1],true)."]</pre>";
		$this->addData('user',$user[1]);
		$this->addData('page-title',I18n::getInstance()->getS('user','edit_title',$user[1]->name));
		
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
	public function save(){
		$user = new User();
		$user->loadFromPost($_POST);
		print_r($user);
		return "view";
	}
	
	/**
	 * create a new user and store to persistance.
	 */
	public function create(){
		return "save";
	}
}
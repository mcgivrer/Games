<?php
class PageManager extends Singleton{
	protected 	$data = array(
        'theme' => "default");
	protected $request = array();
	
	protected $persistance = null;
	
	protected $managerName="";
	
	public function __construct($managerName){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Pragma: no-cache"); 
		$this->request = $_REQUEST;
		//$this->persistance = DataRS::getInstance();
		$this->persistance = Data::getInstance();
		$this->managerName = $managerName;
	}
	
	public function getShortManagerName(){
		return strtolower(preg_replace('/([^\*]+)Manager/','\1',$this->managerName));	
	}
	/**
	 * Display page in VIEW mode
	 */
	public function view(){
		return "master";
	}
	/**
	 * Display page in CREATE mode
	 */
	public function create(){
		return "master";
		
	}
	/**
	 * Display page in UPDATE mode
	 */
	public function update(){
		return "master";
		
	}
	/**
	 * Display page in DELETE mode
	 */
	public function delete(){
		return "master";
		
	}
	
	/**
	 * Include the nedded template.
	 */
	public function display(){
		__debug("path:".__FILE__,"display",__CLASS__);
		$action = (isset($_REQUEST['action'])?$_REQUEST['action']:"view");
		__debug("action: $action","display",__CLASS__);
		$template = call_user_func(array($this,$action));
		$context = new Context();
		$context->set('manager',$this->getShortManagerName());
		$context->set('template',$template);
		$context->set('data',$this->data);
		$context->set('request',$_REQUEST);
		$context->set('roles',array('admin'=>false));
		
		
		Template::getInstance()->setContext($context);
		Template::getInstance()->renderAppContainer();
	}
	
	/**
	 * Add data to page.
	 * @param unknown_type $key
	 * @param unknown_type $value
	 */
	public function addData($key, $value){
		if($key!=""){
			$this->data[$key]=$value;
		}else{
			throw new Exception("Can not insert data to the page: key or value is not correctly set: key:'$key', data:[".print_r($this->data,true)."]");
		}
	}
	
	/**
	 * Return value of a HTTP request (POST or GET)
	 * @param unknown_type $attribute
	 */
	public function getFromRequest($attribute){
		if(isset($this->request) && $this->request[$attribute]!=""){
			return $this->request[$attribute];
		}else{
			return null;
		}
	}
	
	public function getInstance($className=__CLASS__){
		return parent::getSingletonInstance($className);
	}
}
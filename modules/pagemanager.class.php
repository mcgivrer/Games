<?php
class PageManager extends Singleton{
	protected 	$data = array(
        'theme' => "default");
	protected $request = array();
	protected $route = array();
	
	protected $persistance = null;
	
	protected $managerName="";
	
	public function __construct($managerName,$route){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Pragma: no-cache"); 
		$this->request = $_REQUEST;
		$this->route = $route;
		//$this->persistance = DataRS::getInstance();
		$this->persistance = Data::getInstance();
		$this->managerName = $managerName;
		$this->data['theme'] = __requestSession('theme',__config('template','active'));
		$this->data['system/rewrite'] = (__isActive('system','rewritemode')?"":"?");
	}
	
	public function __destruct(){
	}
	
	public function getShortManagerName(){
		return strtolower(preg_replace('/([^\*]+)Manager/','\1',$this->managerName));	
	}
	
	/**
	 * Return <code>$parameter</code> value idientified on <code>$this->route</code> initialized by <code>Router</code>.
	 * @param string $parameter Name of the parameter to retrieve.
	 * @see Router#findRoute()
	 */
	public function getParameter($parameter){
		$route = array();
		$route = $this->route;
		//print_r($route);
		if(isset($route['params'][$parameter])){
			return $route['params'][$parameter];
		}else{
			return null;
		}
	}

	/**
	 * Set display Theme from $s parameter retrieve from <code>$route</code>.
	 */
	public function setTheme(){
		$t = __requestSession('theme','default');
		$this->addData('theme',$t);
		Template::getInstance()->setTheme($t);
		return $this->view();
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
	
	public function flush(){
		session_unset();
	}
	
	/**
	 * Include the nedded template.
	 */
	public function display(){
		$action = __parameterRequest('action',"view",$this);
		__debug("action: $action",__METHOD__,__CLASS__);
		//echo "action:".$action;
		if($action!=""){
			$template = call_user_func(array($this,$action));
		}else{
			Error::addMsg("error","PageManager Error","Can not find the corresponding action $action into the PageManager ".$this->getShortManagerName());
			$template = call_user_func(array($this,"view"));
		}
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
	
	public static function getInstance($className=__CLASS__){
		return parent::getSingletonInstance($className);
	}
}
?>
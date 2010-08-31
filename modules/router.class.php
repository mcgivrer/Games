<?php
__helpers("config");
__helpers("debug");
__helpers("i18n");
__helpers("template");
__helpers("http");
__helpers("html");
__helpers("htmlform");
/**
 * Detect and instanciate the needed PageManager.
 * get the mgr request variable and instanciate the corresponding PageManager.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 10/08/2010
 */
class Router extends Singleton{
	
	private static $routes = array();
	private static $defaultRoute=array();
	
	public function __construct(){
		__debug("default constructor for ".__CLASS__,__METHOD__,__CLASS__);
	}
	
	/**
	 * Load configuration parameters <code>cache/include</code> and <code>cache/exclude</code> to\
	 * initialize Cache configuration.
	 */
	private function initializeCache(){
		__debug("Initialize Cache following config.ini/cache/[include/exclude] parameters",__METHOD__,__CLASS__);;
		$includeFilters = __config('cache','include');
		$excludeFilters = __config('cache','exclude');
		__debug("Cahe engine is ".__config('cache','active'),__METHOD__,__CLASS__);;
		__debug("include:[$includeFilters], exclude:[$excludeFilters]",__METHOD__,__CLASS__);;
		
		if($includeFilters!=""){
			foreach(explode(',',$includeFilters) as $includeFilter){
				Cache::getInstance()->addIncludeFilter($includeFilter);
			}
		}
		if($excludeFilters!=""){
			foreach(explode(',',$excludeFilters) as $excludeFilter){
				Cache::getInstance()->addIncludeFilter($excludeFilter);
			}
		}
	}
	/**
	 * Run the corresponding action for the active manager.
	 */
	public function run(){
		__debug("Call page manager",__METHOD__,__CLASS__);
		session_start();
		$this->initializeCache();
		if(__isActive('cache','active') && Cache::getInstance()->isExists()){
			__debug("cached page",__METHOD__,__CLASS__);
		    Cache::getInstance()->getCachedPage();
		}else{
			__debug("Generate page",__METHOD__,__CLASS__);
		    Cache::getInstance()->start();
		    $manager = $this->getManager();
		    $manager->display();
		    Cache::getInstance()->flush();
		}
	}
	
	/**
	 * Return the needed instance of PageManager.
	 */
	private function getManager(){
		__debug("Detect and instance needed PageManager",__METHOD__,__CLASS__);
		$route = $this->findRoute();
		//echo "<p>getManager()=> route:[".print_r($route,true)."]</p>";
		$managerClass = (isset($route['managerClass'])?$route['managerClass']:"IndexManager");
		__debug("instanciate manager=".$managerClass,"getManager",__CLASS__);
		
		$manager=new $managerClass($managerClass,$route);
		if($manager instanceof PageManager){
			return $manager;
		}else{
			throw new Exception("Error on Router: $managerClass is not a valide PageManeger Object.",10601);
		}
	}
	
	public function findRoute(){
		$identifiedParams = array('managerClass' => "",'params'=>array());
		if(isset($_SERVER['QUERY_STRING'])){
			$request = explode('/',$_SERVER['QUERY_STRING']);
			//echo "<pre>request=[".print_r($request,true)."]</pre>";
			__debug("Parse route array and find corresponding route for '".print_r($request,true)."'",__METHOD__,__CLASS__);
			// if not Url rewrite mode, remove the '?' character in first position.
			if(isset($request[0]) && $request[0]=="?"){
				$request = array_slice($request,1);
			}
			if($request[0]==""){
				$route = self::$defaultRoute;
			}else{
				$route = self::$routes[$request[0]];
				$params = explode('/',$route['path']);
				if(isset($params)&& count($params)>1){
					for($i=0;$i<count($params);$i++){
						$param=$params[$i];
						$value=(isset($request[$i])?$request[$i]:"");
						//echo "<p>param ".$i.":".$param."=".$value."</p>";
						if(isset($param[0]) && $param[0]=="%"){
							$identifiedParams['params'][str_replace('%',"",$param)]=$value;
							__debug("find param $param=$value",__METHOD__,__CLASS__);
						}
					}
				}
			}
		}else{
			$route = self::$defaultRoute;
		}
		if(
			!isset($identifiedParams['params']['action']) 
			|| (
					isset($identifiedParams['params']['action']) 
						&& $identifiedParams['params']['action']==""
				)
			){
			$identifiedParams['params']['action']="view";
		}
		$identifiedParams['managerClass'] = $route['class'];
		__debug("find route :".print_r($identifiedParams,true),__METHOD__,__CLASS__);
		//echo "<p>identifiedParams=".print_r($identifiedParams,true)."</p>";
		return $identifiedParams;
	}
	
	/**
	 * Set the Default route.
	 * @param string $path
	 * @param string $manager
	 */
	public function setDefaultRoute($path,$manager){
		$params = explode('/',$path);
		self::$defaultRoute=array(
						'path'=> $path,
						'class'=> ucfirst(strtolower($manager))."Manager",
						'manager'=>$manager,
						'params' => $params);
	}
	
	/**
	 * Add a route to the Routes array.
	 * <code>path</code> is the identified url part to route to the <code>manager</code>
	 * @param unknown_type $path
	 * @param unknown_type $manager
	 */
	public function addRoute($path,$manager){
		$params = explode('/',$path);
		self::$routes[$params[0]]=array(
						'path'=> $path,
						'class'=> ucfirst(strtolower($manager))."Manager",
						'manager'=>$manager,
						'params' => $params); 
	}
	
	public static function getInstance(){
		return self::getSingletonInstance(__CLASS__);
	}
}
//Internal Routes
include_once("modules/routes.php");
//Application Routes
include_once("config/routes.php");
?>
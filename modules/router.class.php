<?php
__helpers("config");
__helpers("debug");
__helpers("i18n");
__helpers("template");
__helpers("http");
/**
 * Detect and instanciate the needed PageManager.
 * get the mgr request variable and instanciate the corresponding PageManager.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 10/08/2010
 */
class Router extends Singleton{
	public function __construct(){
		__debug("default constructor for ".__CLASS__,"__construct",__CLASS__);
	}
	
	/**
	 * Load configuration parameters <code>cache/include</code> and <code>cache/exclude</code> to\
	 * initialize Cache configuration.
	 */
	private function initializeCache(){
		__debug("Initialize Cache following config.ini/cache/[include/exclude] parameters","initializeCache",__CLASS__);
		$includeFilters = __config('cache','include');
		$excludeFilters = __config('cache','exclude');
		__debug("Cahe engine is ".__config('cache','active'),"initializeCache",__CLASS__);
		__debug("include:[$includeFilters], exclude:[$excludeFilters]","initializeCache",__CLASS__);
		
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
		__debug("Call page manager","run",__CLASS__);
		session_start();
		$this->initializeCache();
		if(Cache::getInstance()->isExists() && __isActive('cache','active')){
			__debug("cached page","index",__FILE__);
		    Cache::getInstance()->getCachedPage();
		}else{
			__debug("Generate page","index",__FILE__);
		    Cache::getInstance()->start();
		    $manager = $this->getManager();
		    $manager->display();
		    Cache::getInstance()->flush();
		}
	}
	
	private function getManager(){
		$managerName = (isset($_REQUEST['mgr'])?$_REQUEST['mgr']:"index");
		$managerClass = ucfirst($managerName)."Manager";
		__debug("instanciate manager=".$managerClass,"getManager",__CLASS__);
		$manager=new $managerClass;
		return $manager;		
	}
	
	public static function getInstance(){
		return self::getSingletonInstance(__CLASS__);
	}
}
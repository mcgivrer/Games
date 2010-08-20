<?php
/*
 * Template Engine 
 * Manage multiple themes rendering and support specific i18n, scripts and styles.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
 *
 */

/**
 * ThemeDescriptor reresenting one theme information.
 */
class ThemeDescriptor extends SimpleXMLElement {
	public $shortname;
	public $name;
	public $description;
	public $version;
	public $date;
	public $author;
	public $author_long;
	public $encoding;
	public $path;
}

/**
 * Template class managing multiple themes and the rendering layers.
*/
class Template extends Singleton{
	
	static private $themes=array();
	
	static private $active="";
	
	static private $context=array();
	
	public function __construct(){
		$this->buildThemesList();
		$this->setTheme(__requestSession('theme',__config('template','active')));
	}
	
	/**
	 * Load theme.xml files from /themes/ path to build list of available themes.
	 */
	private function buildThemesList() {
		__debug("",__METHOD__,__CLASS__);
		$basePath = dirname(__FILE__)."/../themes/";
		$dir = opendir($basePath);
		while(($theme=readdir($dir))!== false){
			if(file_exists($basePath.$theme."/"."theme.xml")){
				$themexml = simplexml_load_file($basePath.$theme."/"."theme.xml","ThemeDescriptor");
				$themexml->path = $basePath.$theme."/";
				self::$themes["".$themexml->shortname] = $themexml;
			}
		}
		//echo("<pre>themes:[".print_r(self::$themes,true)."]</pre>");
	}

	/**
	 * Set active theme.
	 * @param string $shortname shortname
	 */
	public function setTheme($shortname){
		if(array_key_exists($shortname,self::$themes)){
			self::$active = self::$themes["".$shortname];
			I18n::getInstance()->addI18nTheme("".$this->getTheme()->shortname);
		}else{
			throw new Exception("Theme '$shortname' does not exists.",20001);
		}
	}
	
	public function getTheme(){
		return self::$active;
	}

	/**
	 * Set contextual data for rendering purpose.
	 * @param string $manager current manager (shortname)
	 * @param string $template template to use for rendering page (linked to Manager action)
	 * @param array $data data manipulated for this display.
	 */
	public function setContext($context){
		if($context instanceof Context){
			self::$context=$context;
		}else{
			throw new Exception("Context set is not a Context class instance.",20002);
		}
	}

	/**
	 * Display the application template for the application container.
	 * @param string $entity name of the entity to be displayed.
	 * @param string $action action for this entity (corresponding to the template file name)
	 * @param array $data data to be parse for this page.
	 */
	public function renderAppContainer($manager="",$template="",$data=""){
		$attributes = self::$context->getAll();
		foreach($attributes as $key=>$value){
			$$key = $value;
			__debug("context item: $key = $value",__METHOD__,__CLASS__);
		}
		$data['theme-info'] = self::$active;
		$data['themes'] = self::$themes;
		include_once("themes/".self::$active->shortname."/application.tpl");
	}
	
	/**
	 * Display the master template for a manager.
	 * @param string $manager shortname of the manager.
	 * @param string $template name of the template to use fo this manager (returned value from Manager action method, by default 'master').
	 * @param array $data data to be parse for this page
	 */
	public function renderMaster($manager="",$template="",$data=""){
		__debug("manager=$manager, template=$template",__METHOD__,__CLASS__);
		$attributes = self::$context->getAll();
		foreach($attributes as $key=>$value){
			$$key = $value; 
		}
		$data['theme-info'] = self::$active;
		$data['themes'] = self::$themes;
		//echo "manager= $manager, template=$template<br/>";
		$applicationTemplate = explode('/',$template);
		if(count($applicationTemplate)>1 && $applicationTemplate[0]=="application"){
			//echo "Application level template";
			include_once("themes/".self::$active->shortname."/managers/".$applicationTemplate[1].".tpl");
		}else{
			//echo "Standard manager level template";
			include_once("themes/".self::$active->shortname."/managers/".$manager."/".$template.".tpl");
		}
	}

	
	/**
	 * Display the action template for an entity.
	 * @param string $entity name of the entity to be displayed.
	 * @param string $action action for this entity (corresponding to the template file name)
	 * @param array $data data to be parse for this page.
	 */
	public function renderEntity($entity,$action,$data){
		$attributes = self::$context->getAll();
		foreach($attributes as $key=>$value){
			if($key!='data'){
				$$key = $value; 
			}
		}
		$data['theme-info'] = self::$active;
		$data['themes'] = self::$themes;
		include_once("themes/".self::$active->shortname."/entities/".$entity."/".$action.".tpl");
	}

	/**
	 * Singleton
	 */
	public static function getInstance(){
		return self::getSingletonInstance(__CLASS__);
	}
}
?>
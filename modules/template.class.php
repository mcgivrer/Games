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
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
 */
class ThemeDescriptor extends SimpleXMLElement {
	public $shortname;
	public $name;
	public $description;
	public $version;
	public $date;
	public $author;
	public $encoding;
	public $path;
}

/**
 * Template class managing multiple themes and the rendering layers.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
*/
class Template extends Singleton{
	
	static private $themes=array();
	
	static private $active="";
	
	static private $context=array();
	
	public function __construct(){
		$this->active = __config('template','active');
		$this->buildThemesList();
		I18n::getInstance()->addI18nTheme($this->getActive());
	}
	
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
		echo("<pre>themes:[".print_r(self::$themes,true)."]</pre>");
	}

	public function setActive($activated){
		$this->active = $activated;
	}
	
	public function getActive(){
		return $this->active;
	}

	/**
	 * Set contextual data for rendering purpose.
	 * @param string $manager current manager (shortname)
	 * @param string $template template to use for rendering page (linked to Manager action)
	 * @param array $data data manipulated for this display.
	 */
	public function setContext($context){
		self::$context=$context;
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
		include_once("themes/".$this->active."/application.tpl");
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
		/*if($manager=="") $manager=self::$context['manager'];
		if($template=="") $template=self::$context['template'];
		if($data=="") $data=self::$context['data'];
		$request=self::$context['request'];
		*/
		include_once("themes/".$this->active."/managers/".$manager."/".$template.".tpl");
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
		include_once("themes/".$this->active."/entities/".$entity."/".$action.".tpl");
	}

	/**
	 * Singleton
	 */
	public static function getInstance(){
		return self::getSingletonInstance(__CLASS__);
	}
}
?>
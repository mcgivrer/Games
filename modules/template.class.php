<?php
class Template {
	
	static private $_instance;
	
	static private $active;
	
	static private $context;
	
	public function __construct(){
		$this->active = __config('template','active');
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
	public function setContext($manager,$template,$data,$request,$roles){
		self::$context=array(
				'manager'=>$manager,
				'template'=>$template,
				'data'=>$data,
				'request'=>$request,
				'roles'=>$roles);
	}

	/**
	 * Display the application template for the application container.
	 * @param string $entity name of the entity to be displayed.
	 * @param string $action action for this entity (corresponding to the template file name)
	 * @param array $data data to be parse for this page.
	 */
	public function renderAppContainer($manager="",$template="",$data=""){
		
		foreach(self::$context as $key=>$value){
			$$key = $value; 
		}
		/*if($manager=="") $manager=self::$context['manager'];
		if($template=="") $template=self::$context['template'];
		if($data=="") $data=self::$context['data'];
		$request=self::$context['request'];*/
		include_once("themes/".$this->active."/application.tpl");
	}
	
	/**
	 * Display the master template for a manager.
	 * @param string $manager shortname of the manager.
	 * @param string $template name of the template to use fo this manager (returned value from Manager action method, by default 'master').
	 * @param array $data data to be parse for this page
	 */
	public function renderMaster($manager="",$template="",$data=""){
		if($manager=="") $manager=self::$context['manager'];
		if($template=="") $template=self::$context['template'];
		if($data=="") $data=self::$context['data'];
		$request=self::$context['request'];
		include_once("themes/".$this->active."/managers/".$manager."/".$template.".tpl");
	}

	
	/**
	 * Display the action template for an entity.
	 * @param string $entity name of the entity to be displayed.
	 * @param string $action action for this entity (corresponding to the template file name)
	 * @param array $data data to be parse for this page.
	 */
	public function renderEntity($entity,$action,$data){
		$request=self::$context['request'];
		include_once("themes/".$this->active."/entities/".$entity."/".$action.".tpl");
	}

	/**
	 * Singleton
	 */
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance=new Template();
		}
		return self::$_instance;
	}
}
?>
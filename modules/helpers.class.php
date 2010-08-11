<?php
class Helpers {
	private static $_instance;
	
	public function __construct() {
		//echo"<pre>helpers</pre>";
		require_once(dirname(__FILE__)."/autoloader.lib.php");		
	}
	
	public function load($name){
		//echo"<pre>load ".dirname(__FILE__)."/helpers/$name.helpers.php"."</pre>";
		require_once(dirname(__FILE__)."/helpers/$name.helpers.php");
	}
	
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new Helpers();
		}
		return self::$_instance;
	}
}
function __helpers($name){
	Helpers::getInstance()->load($name);
}
?>
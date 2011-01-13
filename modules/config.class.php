<?php
/**
 * Configuration manager.
 * Load the config/config.ini file into a PHP array, following groups and key.
 * you will be able to get key value with the <code>get($group,$key,$default)</code> method,
 * where $group/$key are value unique identifier, and $default, a default value if group/key
 * not found into configuration file.
 *
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.3
 * @copyright 2010/08/08
 *
 */
class Config{
	private static $_instance = null;
	private static $_parameters = null;

	/**
	 * Load config.ini file into the static private array.
	 */
	public function __construct(){
		if(file_exists(dirname(__FILE__)."/../config/config.ini")){
			self::$_parameters = parse_ini_file(dirname(__FILE__)."/../config/config.ini",true);
		}else{
			throw new ConfigurationException("Can not load Config.ini file from config/ path. Please verify your project tree.");
		}
	}

	/**
	 * return the key based on $group and $key identifiers.
	 * @param $group
	 * @param $key
	 */
	public function get($group,$key, $default=""){
		if(isset(self::$_parameters[$group])&&isset(self::$_parameters[$group][$key])){
			return self::$_parameters[$group][$key];
		} else if($default==""){
			return "Property $group/$key does not exists";
		} else {
		    return $default;
		}
	}
	/**
	 * Dynamic update for Config file, but this change didn't persist.
	 * @param unknown_type $group
	 * @param unknown_type $key
	 * @param unknown_type $value
	 */
	public function set($group,$key,$value){
		self::$_parameters[$group][$key]=$value;
	}

	/**
	 * test if a flag is set into config.ini file.
	 * possible value for th flag are "on", "true" or "1".
	 * @see Debug::get($group,$key)
	 * @return true if flag is set, or false.
	 */
	public function isActive($group,$key){
		$msg = $this->get($group,$key) ;
		if( $msg == "on" || $msg=="true" || $msg=="1"){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * initialise parmaters from config.ini file.
	 */
	public static function getInstance(){
		if(!isset(self::$_instance) || self::$_instance == null){
			self::$_instance = new Config();
		}
		return self::$_instance;
	}

    public function __autoload($name){
    	if($name==__CLASS__){
    		return Config::getInstance();
    	}
    }
}
?>


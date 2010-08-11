<?php
/**
 * Internationalization management
 * With the basic methods <code>get($group,$key)</code> and <code>getS($group,$key,$args)</code>
 * you will be able to retrive transleted pieces of text from the <code>./i18n/</code> path.
 * If needed, you will be able to add other <code>.ini</code> file throught dynamique loading, 
 * and automaticaly added to the main bundle of translated text.
 * The method <code>addI18nTheme($path) will help you on adding <code>application.ini</code> file.</code>.
 * 
 * the method <code>removeHtml($group,$key)</code> will remove all specific HTML tags from value from I18n retrieved value.
 * 
 * Helpers are available from "<code>/helpers/i18n.helpers.php</code>":
 *  - __($group,$key)  for get(),
 *  - __s($group,$key,$args) for getS(),
 *  - __h($group,$key) for removeHtml().
 * 
 * @author Frédéric Delorme<frederic.delorme@web-context.com>
 * @version 1.0 
 * @copyright 2010/05/15
 */
class I18n extends Singleton{
	private static $_language = null;
	private static $_langkey  = "en_EN";
	private static $_themes = array();
	private static $debug = null;

	/**
	 * Default constructor.
	 */
	public function __construct(){
		self::$debug = Debug::getInstance(__CLASS__);
		self::$_langkey = Config::getInstance()->get("system","language");
		if(!isset(self::$_language) || self::$_language == null){
			self::$_language = parse_ini_file(dirname(__FILE__)."/../i18n/".self::$_langkey."/main.properties",true);
			__debug("path:["."i18n/".self::$_langkey."/main.properties]","I18n");
			__debug("messages=".print_r(self::$_language,true),"I18n");
		}
	}
	/**
	 * Add a new Language pack definitionaccording to the theme selected. 
	 * @param String $themepath name of the theme.
	 */
	public function addI18nTheme($themepath){
		__debug("Add template I18n definitions - start","addI18nTheme");
		$i18npath = "public/templates/".$themepath."/i18n/".self::$_langkey."/application.ini";
		if(!isset(self::$_themes[$themepath]) && file_exists(dirname(__FILE__)."/../../".$i18npath)){
			__debug("file for [".$themepath."/".self::$_langkey."] exists [".$i18npath."]. Added.","addI18nTheme");
			$themeI18n = parse_ini_file($i18npath,true);
			self::$_themes[$themepath]=$themepath;
			self::$_language = array_merge(self::$_language,$themeI18n);
		}else{
			__debug("file for [".$themepath."/".self::$_langkey."] does not exist [".$i18npath."]!","addI18nTheme");
		}
		__debug("Theme I18n definition - end","addI18nTheme");
	}
	/**
	 * return the message based on $group and $key identifiers.
	 * @param $group
	 * @param $key
	 */
	public function get($group,$key){
		__debug("start : group=$group, key=$key","get");
		if(isset(self::$_language[$group]) && isset(self::$_language[$group][$key])){
			return self::$_language[$group][$key];
		}else{
			return "message $group/$key not defined in ".self::$_langkey;
		}
	}
	/**
	 * return parameterized message based
	 * @param $group
	 * @param $key
	 */
	public function getS($group,$key,$args){
		__debug("group=$group, key=$key","getS");
		$msg=self::get($group,$key);
		$msg = mb_convert_encoding(self::get($group,$key),Config::getInstance()->get("system","encoding"));

		for($i=0;$i < count($args); $i++){
			$msg = str_replace("{".$i."}",$args[$i],$msg);
		}
		return $msg;
	}
	/**
	 * return message cleaned from any html tags.
	 * @param $group
	 * @param $key
	 */
	public function removeHtml($group,$key){
		__debug("group=$group, key=$key","removeHtml");
		$msg=self::get($group,$key);
		return strip_tags($msg);
	}
	/**
	 * initialise language from config.ini file.
	 */
	public function getInstance(){
		return self::getSingletonInstance(__CLASS__);
	}
}
?>
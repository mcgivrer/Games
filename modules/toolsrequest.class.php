<?php
class ToolsRequest extends Singleton{
	/**
	 * Get a value from the REQUEST (POST or GET) and store it into the SESSION. 
	 * if <code>cookie</code> flag = true, the value will be also stored on the client browser, and retrieved from
	 * it if other depot are empty (order: REQUEST, SESSION, COOKIE,default value).
	 * @param string $parameter name of the parameter
	 * @param string $defaultValue default value if parameter does not exists in REQUEST, SESSION or COOKIE
	 * @param boolean $cookie if true, retrieved value will be stored into a cookie on client browser.
	 */
	public function requestSession($parameter, $defaultValue="", $store=""){
		__debug("parameter='$parameter', defaultValue='$defaultValue', store='$store'",__METHOD__,__CLASS__);
		// load key's value from Request, or from session, od set to defaut value.
		$value = (isset($_REQUEST["".$parameter])?$_REQUEST["".$parameter]:
					(isset($_SESSION["".$parameter])?$_SESSION["".$parameter]:
						(self::getCookie($parameter,"")!=""?self::getCookie($parameter,""):
							$defaultValue)));
		// store key's value into session.
		if(strstr(strtolower($store),"session")!=false){
			$_SESSION["".$parameter]=$value;
		}
		if(strstr(strtolower($store),"cookie")!=false){
			self::setCookie($parameter, $value);
		}
	return $value;
	} 
	
	/**
	 * Get a value from the REQUEST (POST or GET) and store it into the SESSION. 
	 * if <code>cookie</code> flag = true, the value will be also stored on the client browser, and retrieved from
	 * it if other depot are empty (order: REQUEST, SESSION, COOKIE,default value).
	 * @param string $parameter name of the parameter
	 * @param string $defaultValue default value if parameter does not exists in REQUEST, SESSION or COOKIE
	 * @param boolean $cookie if true, retrieved value will be stored into a cookie on client browser.
	 */
	public function parameterRequest($parameter, 
				$defaultValue="", 
				$manager=null, 
				$store=""){
		__debug("parameter='$parameter', defaultValue='$defaultValue', manager='".$manager->getShortManagerName()."', store='$store'",__METHOD__,__CLASS__);
		// load key's value from Request, or from session, od set to defaut value.
		$paramValue = $manager->getParameter($parameter);
		//echo "<pre>get parameterRequest($parameter) =>'".$paramValue."'</pre>";
		$value =(isset($paramValue)?$paramValue: 
					(isset($_REQUEST[$parameter])?$_REQUEST[$parameter]:""));
		if($value==""){
			if(strstr(strtolower($store),"session")!=false && isset($_SESSION["".$parameter])){
				$value = $_SESSION["".$parameter];
			}
			if($value=="" && strstr(strtolower($store),"cookie")!=false && isset($_COOKIE["".$parameter])){
				$value = $_COOKIE["".$parameter];
			}elseif($value==""){
				$value=$defaultValue;
			}
		}
		// store key's value into session.
		if($value !="" && strstr(strtolower($store),"session")!=false){
			$_SESSION["".$parameter]=$value;
		}
		if($value !="" && strstr(strtolower($store),"cookie")!=false){
			self::setCookie($parameter, $value);
		}
		//echo "<pre>returned value:' $value'</pre>";
		return $value;
	}
	
	/**
	 * 
	 * Return a cookie value if it exists.
	 * @param string $attribute name of the cookie (concatained with the config.ini[system/cookie_identifier] value.
	 * @param string $default
	 */
	public function getCookie($attribute,$default=""){
		__debug("attribute='$attribute', default='$default'",__METHOD__,__CLASS__);
		$prefix = __config('system','cookie_identifier')."_";
		if(isset($_COOKIE[$prefix.$attribute])){
			return $_COOKIE[$prefix.$attribute];
		}else{
			return $default;
		}
	}

	/**
	 * Fix a cookie value based on the configured cookie prefix in
	 * the config.ini [system/cookie_identifier] value.
	 * 
	 * @param string $attribute name of the cookie concatained with the configured [system/cookie_identifier] value.
	 * @param string $value value of the attribute.
	 * @param unknown_type $expire delai of expiration. by default 2592000 sec. (=>30 days).
	 */
	public function setCookie($attribute,$value,$expire=2592000){
		$prefix = __config('system','cookie_identifier')."_";
		setcookie($prefix.$attribute,$value,time()+60*60*24*30);
	}

	/**
	 * Instance.
	 */
	public static function getInstance(){
		return parent::getSingletonInstance(__CLASS__);
	}
}
?>
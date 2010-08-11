<?php
/**
 * Smartphone and Mobile Detector
 * Base on a list of mobile agent, try to detect is Browser is running on a smartphone
 * or any Mobile.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 *
 */
class SmartDetector{
	/**
	 * Sigleton pattern instance
	 * @var SmartDetector
	 */
	private static $_instance = null;

	/**
	 * List of known user agents.
	 */
	private $mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda','xda-');
	/**
	 * Flag:true => Mobile.
	 */
	private $mobile=false;

	public function __construct(){

	}

	public function detect(){
		$mobile_browser = '0';

		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}

		if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}

		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));

		if(in_array($mobile_ua,$this->mobile_agents)) {
			$mobile_browser++;
		}

		if (isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
			$mobile_browser++;
		}

		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
			$mobile_browser=0;
		}

		if($mobile_browser>0) {
			$this->mobile=true;
		}

		return $this->mobile;
	}

	public function isMobile(){
		return $this->detect();
	}

	public static function getInstance(){
		if(self::$_instance==null){
			self::$_instance = new SmartDetector();
		}
		return self::$_instance;
	}
}
?>
<?php
/**
 * Cache manager.
 * if a cache file named following url'ification rules already exists,
 * the file is serve in place of generated one with PHP scripting.
 * Files are store into a default cache path "../cache/" relatively to the root
 * of web site (htdocs, in apache world).
 * 
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.3
 * @copyright 2010/08/08
 */
class Cache{
	static private $_instance = null;
	private $filters = array('include'=>array(),'exclude'=>array());
	private $cachePath ="";
	public function Cache(){
		//echo "<pre>Cache</pre>";
	}
	
	/**
	 * Default constructor for Cache manager.
	 * if $pCachePath is provided, take it in account.
	 * if no cachePath is define, a default one is set.
	 * @param string $pCachePath default path for cache files.
	 */	
	public function __construct($pCachePath=""){
		$this->setCachePath($pCachePath);
	}

	public function setCachePath($pCachePath=""){
		$this->cachePath = ($pCachePath!=""?$pCachePath:($this->cachePath!=""?$this->cachePath:dirname(__FILE__)."/../cache/"));
	}
	
	public function addIncludeFilter($filter){
		$this->filters['include'][$filter]=$filter;
	}

	public function addExcludeFilter($filter){
		$this->filters['exclude'][$filter]=$filter;
	}

	public function notFiltered(){
		if(isset($_REQUEST['nocache'])){
			//echo "<pre>nocache</pre>";
			return false;
		}
		if(isset($_REQUEST['forcerefresh'])){
			//echo "<pre>forcerefresh</pre>";
			return true;
		}
		foreach($this->filters['exclude'] as $filter){
			if($filter!="" && strstr($_SERVER['QUERY_STRING'],$filter)){
				//echo "<pre>exclude filter</pre>";
				return false;
			}
		}
		foreach($this->filters['include'] as $filter){
			if($filter =="*" || (isset($filter) && $filter!="" && strstr($_SERVER['QUERY_STRING'],$filter))){
				//echo "<pre>include filter</pre>";
				return true;
			}
		}
		return true;
	}
	public function isExists(){
		if($this->notFiltered()){
			//echo "<pre>search: ".HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING'])."</pre>";
			$cacheFile = ($this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING'])!=""?$this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING']):"index");
			return file_exists($cacheFile.".cache");
		}else{
			return false;
		}
	}

	public function start(){
		if($this->notFiltered()){
			ob_start();
		}
	}

	public function flush(){
		if($this->notFiltered() || error_get_last()!=null){
			$content= ob_get_contents();
			ob_end_clean();
			$cacheFile = ($this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING'])!=""?$this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING']):"index");
			$file=fopen($this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING']).".cache","w+");
			fputs($file,$content);
			fclose($file);
			echo $content;
		}else{
		   echo "<pre>page cache filtered</pre>";
		}
	}

	public function getCachedPage(){
		$cacheFile = ($this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING'])!=""?$this->cachePath.HtmlTools::encodeUrlParam($_SERVER['QUERY_STRING']):"index");
		$content=file_get_contents($cacheFile.".cache");
		echo $content;
	}

	public static function getInstance($cachePath=""){
		if(!isset(self::$_instance)){
			self::$_instance=new Cache($cachePath);
		}
		return self::$_instance;
	}
}
?>
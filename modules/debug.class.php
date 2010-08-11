<?php
include_once("modules/error.class.php");
class Debug{
	private static $_instance = null;
	private static $path="";
	private static $messages = array();
	
	private $className="";

	const LEVEL_MAIN="MAIN";
	const LEVEL_DEBUG="DEBUG";
	const LEVEL_INFO="DEBUG";
	const LEVEL_WARN="DEBUG";
	const LEVEL_ERROR="DEBUG";
	const LEVEL_FATAL="FATAL";

	public function __construct($pClassName=""){
		if(self::$path==""){
			self::$path = __config("debug","logfilepath");
			if( isset(self::$path) && 
				self::$path!="" && 
				!file_exists(self::$path)){
				$oldpath = self::$path;
				self::$path=dirname(__FILE__)."/../log/debug-trace.log";
				Error::displayError("Configuration Error",
					"<span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:0 7px 50px 0;\"></span>".
					"Error on log file path in <code>config.ini [group:debug / key:logfilepath]</code>".
					"<ul><li>filepath [<code>".$oldpath."</code>] does not exist.</li>".
					"<li>use of following path [<code>".self::$path."</code>] in place of configured one.</li></ul>");			

			}
			$this->className=$pClassName;
			$this->write("------ Start Log for new page ------",Debug::LEVEL_MAIN);
		}
	}

	protected function write($message,$level){
		if(strstr(__config("debug","level"),$level) || $level==Debug::LEVEL_MAIN){
			$file = fopen(self::$path,"a+");
			$msg=date("Y/m/d-h:i:s")."|".$level."|".$this->className."|".$message;
			if(isset($file)){
					fwrite($file,$msg."\r\n");
			}
			if(__isActive("debug","display")){
				self::$messages[]=$msg;
			}
		}
	}

	/**
	 * add a message to the log file.
	 */
	public function addMessage($fct,$msg,$level="DEBUG"){
		if($this->className != null && $this->className != "" && (stristr(__config("debug","filtered"),$this->className)===false)){
			$this->write(($fct!="-UNKNOWN-"?$fct."()":"")."|".$msg,$level);
		}else{
			$this->write(($fct!="-UNKNOWN-"?$fct."()":"")."|".$msg,$level);
		}
	}

	/**
	 * display all debug information to page output
	 * (mainly called from template engine)
	 */
	public function render(){
		if(__isActive("debug","display")){
			echo "<a class=\"button-debug top\" accesskey=\"D\" href=\"#debug\" title=\"opendebug panel\"><u>D</u>ebug</a>";
			echo "<div id=\"debug\" class=\"top\">";
			echo "<div class=\"toolbar\">";
			echo "<div class=\"title\">Debug toolbar</div>";
			echo "<div class=\"action\">";
			echo "<a class=\"button switchview switch-hide\" href=\"#close\" title=\"Switch debug panel\">&nbsp;</a>";
			echo "<a class=\"button movetop\" href=\"#movetop\" title=\"Move panel to top\">&nbsp;</a>";
			echo "<a class=\"button movebottom\" href=\"#movebottom\" title=\"Move panel to bottom\">&nbsp;</a>";
			echo "<a class=\"button reduce\" href=\"#reduce\" title=\"Reduce line number to debug window\">&nbsp;</a>";
			echo "<a class=\"button add\" href=\"#add\" title=\"Add lines to debug window\">&nbsp;</a>";
			echo "<a class=\"button close\" href=\"#reduce\" title=\"Close debug window\">&nbsp;</a>";
			echo "</div>";
			echo "</div>";
			echo "<div class=\"view\">";
			echo " <ul>";
			foreach(self::$messages as $msg){
				echo "  <li>".$msg."</li>";
			}
			echo " </ul>";
			echo "</div>";
			echo "</div>";
		}
	}
	
	/**
	 * Set current className.
	 * @param $className
	 * @return unknown_type
	 */
	public function setClassName($className=""){
		if($className!="") $this->className=$className;
	}
	
	/**
	 * initialise Debug output and log file.
	 */
	public function getInstance($pClassName=""){
		if(!isset(self::$_instance) || self::$_instance == null){
			self::$_instance = new Debug($pClassName);
		}else{
			self::$_instance->setClassName($pClassName);
		}
		return self::$_instance;
	}
}
?>
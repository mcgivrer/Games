<?php 
/**
 * Error Class Manager. 
 * Manage array containing error messages to be displayed to user.
 * @author Frédéric Delorme
 * @version 1.0 - 20100705
 */
class Error{
	/**
	 * Array of structure containing messages.
	 * @var array() with structure array('class'=>"class",'title'=>"title",'message'=>"message")
	 */
	private static $_errorMsg = array();
	/**
	 * Add a message into Error Pipe.
	 * @param unknown_type $class
	 * @param unknown_type $title
	 * @param unknown_type $message
	 */
	private static function addMsg($class,$title,$message){
		self::$_errorMsg[]=array('class'=>"$class",
								 'title'=>"$title",
								 'message'=>"$message");
	}
	/**
	 * Direct online display of error.
	 * @param unknown_type $title
	 * @param unknown_type $message
	 */
	public static function displayError($title,$message){
		Error::addMsg("error",$title,$message);
	}
	/**
	 * Direct online display of error.
	 * @param unknown_type $title
	 * @param unknown_type $message
	 */
	public static function displayWarning($title,$message){
		Error::addMsg("warning",$title,$message);
	}
	/**
	 * Direct online display of error.
	 * @param unknown_type $title
	 * @param unknown_type $message
	 */
	public static function getMessagesArray(){
		return self::$_errorMsg;
	}
}
?>
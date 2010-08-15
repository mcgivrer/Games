<?php
/**
 * Abstract Class for Singleton Pattern management.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/15
 *
 */
abstract class Singleton 
{
	/**
	 * INstances array maintained by the class.
	 * @var Array
	 */
    private static $_instances=array();
    
    /**
     * To be implemented in all childs of this pattern.
     * method must call parrent::getSingletonInstance(__CLASS__);
     * to return to Singleton manager the class name to be instanciate.
     */
 	public abstract static function getInstance(); 
 	
 	/**
 	 * return unique instance of the class <code>$className</code>.
 	 * @param string $className
 	 */
    public static function getSingletonInstance($className){
    	__debug("Return an instance of the needed class $className","getSingletonInstance",__CLASS__);
        $classNameString = "".$className;
        if (!isset(self::$_instances[$classNameString])){
            self::$_instances[$classNameString] = new $classNameString;
        }
 		//echo "<pre>instances:{".print_r(self::$_instances,true)."}</pre>";
        return self::$_instances[$classNameString];
    }
 
    //TODO Do not allow an explicit call of the constructor: $v = new Singleton();
    //final private function __construct() { }
 
    // Do not allow the clone operation: $x = clone $v;
    final private function __clone() { }
}
?>
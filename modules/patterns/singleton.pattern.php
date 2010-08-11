<?php
class Singleton 
{
    private static $_instances=array();
 
    public static function getSingletonInstance($className){
    	__debug("Return an instance of the needed class $className","getSingletonInstance",__CLASS__);
        $classNameString = "".$className;
        if (!isset(self::$_instances[$classNameString])){
            self::$_instances[$classNameString] = new $classNameString;
        }
 		//echo "<pre>instances:{".print_r(self::$_instances,true)."}</pre>";
        return self::$_instances[$classNameString];
    }
 
    // Do not allow an explicit call of the constructor: $v = new Singleton();
    //final private function __construct() { }
 
    // Do not allow the clone operation: $x = clone $v;
    final private function __clone() { }
}
?>
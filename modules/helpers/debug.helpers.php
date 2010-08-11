<?php
function __debug($message,$fct="",$className=""){
		Debug::getInstance($className)->addMessage($fct,$message,"DEBUG");
}
function __warn($message,$fct="",$className=""){
		Debug::getInstance($className)->addMessage($fct,$message,"WARN");
}
function __info($message,$fct="",$className=""){
		Debug::getInstance($className)->addMessage($fct,$message,"INFO");
}
function __error($message,$fct="",$className=""){
		Debug::getInstance($className)->addMessage($fct,$message,"ERROR");
}
function __renderDebugDisplay(){
	Debug::getInstance()->render();
}
?>
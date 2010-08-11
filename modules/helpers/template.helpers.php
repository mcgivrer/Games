<?php 
/**
 * Render the main template manager <code>master.tpl</code>.
 * @param $manager
 * @param $template
 * @param $data
 */
function __render(){
	Template::getInstance()->renderMaster();
}
/**
 * Render Entity template based on <code>$action</code>. 
 * <code>data</code> are available for rendering.
 * <code>entity</code> is the name of the manipulated entity for this display.
 * @param $entity
 * @param $action
 * @param $data
 */
function __renderEntity($entity,$action,$data){
	Template::getInstance()->renderEntity($entity,$action,$data);
}
?>

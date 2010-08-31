<?php
function __generateForm($entity,$action){
	$htmlForm = new HtmlForm(get_class($entity),$action);
	$htmlForm->generateFormForEntity($entity);
	echo $htmlForm->serialize();
}
<?php
/**
 * Generate Form for the concerned entity.
 * @param Entity $entity Object where to perform Form generation
 * @param String $action type of action ('save','delete')
 * @param String $label Form title 
 * @param String $method Form send method (default POST)
 */
function __generateForm($entity,$action="",$label="",$method="POST"){
	$htmlForm = new HtmlForm(
			get_class($entity),
			$action,
			null,
			null,
			array(	'method'=>$method,
						'label'=>$label)
			);
	$htmlForm->generateFormForEntity($entity);
	echo $htmlForm->serialize();
}
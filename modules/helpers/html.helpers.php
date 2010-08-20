<?php
/**
 * Calcule link based on Path, label and title.
 * @param string $path
 * @param string $label
 * @param string $title
 */
function __link($path,$label,$title="",$options=null){
	$attributes="";
	if($options!=null){
		foreach($options as $key=>$value){
			$attributes .= "$key=\"$value\""; 
		}
	} 
	echo "<a href=\"".__getRewiteMode().$path."\"".($title!=""?" title=\"$title\"":"")." $attributes>$label</a>";
}
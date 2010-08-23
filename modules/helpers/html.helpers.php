<?php
/**
 * Calcule link based on Path, label and title.
 * @param string $path
 * @param string $label
 * @param string $title
 */
function __link($path,$label,$title="",$options=null){
	$accesskey="";
	$accessflag=false;
	if(strpos($label,'_')!==false){
		$pos = strpos($label,'_');
		$accesskey=$label[$pos+1];
	}
	$attributes="";
	if($options!=null){
		foreach($options as $key=>$value){
			if($key=="accesskey"){
				$accessflag=true;
			}
			$attributes .= " $key=\"$value\""; 
		}
	}
	//echo "$pos:$accesskey/$accessflag"; 
	if(!$accessflag && $accesskey!=""){
		$label = str_replace('_','',$label);
		$label = str_replace($accesskey,"<u>$accesskey</u>",$label);
		$attributes .= " accesskey=\"$accesskey\""; 
	}
	echo "<a href=\"".__getRewiteMode().$path."\"".($title!=""?" title=\"$title\"":"")." $attributes>$label</a>";
}
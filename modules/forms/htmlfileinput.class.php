<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlFileInput extends HtmlComponent{
		public function __construct($name, $value,$label="",$htmlAttributes=array('cols'=>"20",'maxlength'=>"255",'class'=>"text")){
			parent::__construct("input","file",$name,$value,$label,$htmlAttributes);			
		}
} 
?>
<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlTextInput extends HtmlComponent{
		public function __construct($name, $value,$label="",$htmlAttributes=array('cols'=>"20",'maxlength'=>"20",'class'=>"text")){
			parent::__construct("input","text",$name,$value,$label,$htmlAttributes);			
		}
} 
?>
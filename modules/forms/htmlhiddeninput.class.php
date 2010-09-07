<?php
/**
 * Html Hidden Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlHiddenInput extends HtmlComponent{
		public function __construct($name, $value,$label="",$htmlAttributes=array('cols'=>"20",'maxlength'=>"20",'class'=>"text")){
			parent::__construct("input","hidden",$name,$value,$label);
			parent::setTemplate("{component}");	
		}
} 
?>
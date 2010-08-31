<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlPasswordInput extends HtmlComponent{
		public function __construct($name, $value,$label="",$htmlAttributes=array('cols'=>"20",'maxlength'=>"20",'class'=>"text")){
			parent::__construct("input","password",$name,$value,$label,$htmlAttributes);
		}
} 
?>
<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlCancelButton extends HtmlComponent{
		public function __construct($name,$value,$label="",$htmlAttributes=array('class'=>"button cancel")){
			parent::__construct("input","submit",$name,$value,$label,$htmlAttributes,null,"{component}");
		}
} 
?>
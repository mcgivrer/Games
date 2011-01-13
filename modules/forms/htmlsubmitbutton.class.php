<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlSubmitButton extends HtmlComponent{
		public function __construct($name,$value,$label="",$htmlAttributes=array('class'=>"button submit")){
			//echo "<pre>Submit:$name,$value,$label</pre>";
			parent::__construct("input","submit",$name,$value,$label,$htmlAttributes,null,"{component}");
		}
} 
?>
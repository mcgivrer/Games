<?php
/**
 * Html Input Text Component.
 * 
 * @author frederic
 *
 */
 class HtmlSelect extends HtmlComponent{
		public function __construct($name, $value,$label="",
									$htmlAttributes=array('size'=>"1",'class'=>"select"), 
									$selectOptions=array('-1' => "")){
			$options  = array();
			if($selectOptions!=null){
				foreach(explode(',',$selectOptions) as $item){
					list($key,$value)=explode(':',$item);
					$options[$key]=$value;
				}
			}
			parent::__construct("select","text",$name,$value,$label,$htmlAttributes,$options);			
		}
		
} 
?>
<<?php
/**
 * Default HTML component object.
 * all Html input would inherit from this object definition.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/24
 */
class HtmlComponent{
	/*
	 * Internal object counter
	 */
	protected $counter=0;
	protected $html ="";
	protected $htmlAttributes=array();
	protected $input="input";
	protected $type="text";
	protected $label="";
	protected $value="";
	
	/**
	 * Default constructor.
	 * @param unknown_type $input
	 * @param unknown_type $type
	 * @param unknown_type $name
	 * @param unknown_type $label
	 * @param unknown_type $value
	 * @param unknown_type $htmlAttributes
	 */
	public function __construct(
				$input="input", 
				$type="text", 
				$name="",
				$label="",
				$value="",
				$htmlAttributes=null){
					
		$this->counter++;
		$this->label=$label;
		$this->input = $input;
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
	}
	
	/**
	 * Serialize data.
	 * @param HtmlForm $form form object containing this component.  
	 */
	public function serialize($form=null){
		
		$this->html .= "<".$this->input.($type!=""?" type=\"".$this->type."\"":"");
		foreach($htmlAttributes as $key=>$value){
			$this->html .= " $key=\"$value\"";		
		}
		$this->html .= "/>";
		return $this->html;
	}	
	
	/**
	 * Default control value.
	 */
	public function control($value=""){
		return true;
	}
}
?>
<?php
class HtmlGroup extends HtmlComponent{
	protected $childComponents=null;
	
	public function __construct($name,$childComponents,$legend="",$htmlAttributes=null){
		parent::__construct("fieldset","",$name,$value="",$label=$legend,$htmlAttributes);
		$this->template = "{component}";
		$this->childComponents = $childComponents;
	}
	
	/**
	 * Render Fieldset (group) of components.
	 * @param unknown_type $form
	 */
	public function serialize($form){
		$html =  "<fieldset name=\"".$this->name."\">";
		$html .= (isset($this->label) && $this->label=""?"<legend>".$this->label."</legend>":"");
		if(isset($this->childComponents)){
			foreach($this->childComponents as $component){
				if($component instanceof HtmlComponent){
					$html .= $component->serialize($this);
				}
			}
		}
		$html .= "</fieldset>";
		print_r(htmlentities($html));
		$this->html =str_replace(array('{component}'),array($html),$this->template); 
		return $this->html;
	}
	
}
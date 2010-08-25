<?php
class HtmlForm{
	private $formComponents = array();

	/**
	 * Default Constructor.
	 * @param unknown_type $name
	 * @param unknown_type $action
	 * @param unknown_type $components
	 */
	public function __construct($name,$action,$components=null,$options=array()){
		$this->name= $name;
		$this->action = $action;
		$this->options = $options;
		if($components!=null){
			$this->formComponents=$components;
			$this->serialize();
		}
	}
	public function add($component){
		$this->formComponants[]=$component;
	}
	
	public function serialize(){
		echo "<form name=\"".$this->name."\" action=\"".$this->action."\">";
		foreach($this->formComponents as $component){
			if($component instanceof HtmlComponent){
				$component->serialize();
			}
		}
		echo "</form>";
	}
} 
?>
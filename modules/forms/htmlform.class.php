<?php
class HtmlForm{
	private $entity;
	private $formComponents = array();
	private $method="POST";
	private $action="edit";
	private $name="form";
	private $htmlAttributes= null;
	private $options = null;
	private $enctype="";
	/**
	 * Default Constructor.
	 * @param unknown_type $name
	 * @param unknown_type $action
	 * @param array $components
	 * @param array $htmlAttributes
	 * @param array $options
	 */
	public function __construct($name,$action,$components=null,$htmlAttributes=null,$options=null){
		$this->name= $name;
		$this->action = $action;
		$this->htmlAttributes= $htmlAttributes;
		$this->options = $options;
		if($components!=null){
			$this->formComponents=$components;
			$this->serialize();
		}
	}
	
	public function add($component){
		if($component instanceof HtmlComponent){
			$this->formComponents[$component->name]=$component;
		}else{
			throw new Exception("Component with name ".$component->name." already exists in form ".$this->name,90201);
		}
	}
	
	/**
	 * Generate the form for the $entity.
	 * @param unknown_type $entity
	 */
	public function generateFormForEntity($entity,$action=""){
		$components = array();
		$this->entity = $entity;
		$this->action = ($action!=""?$action:$this->action);
		$group = new HtmlGroup(
									$entity->entityName,
									null,
									($this->options!=null && isset($this->options['label'])
										?$this->options['label']
										:__s($entity->entityName,$entity->entityName."_".$action."_label",$entity->id)
									)
								);

		foreach($entity->getAttributes() as $key=>$attribute){
			$type=$entity->getAttributeType($key);
			//print_r($type);
			switch($type['type']){
				case 'Text':
					if($key!="id" && $key!="entityName"){
						$group->add(new HtmlTextInput(
														$key,
														$attribute,
														__(strtolower($entity->entityName),$key."_label",htmlentities($key)),
														array(
															'cols'=>$type['size'],
															'maxlength'=>( isset($type['options']['maxlength'])
																			?$type['options']['maxlength']
																			:$type['size'])
																)
													)
											);
					}else{
						$group->add(new HtmlHiddenInput($key,$attribute,""));
					}
					break;
				case 'Password':
					$group->add( new HtmlPasswordInput(
											$key,
											$attribute,
											__(strtolower($entity->entityName),$key."_label","$key"),
											array(
												'cols'=>$type['size'], 
												'maxlength'=>( isset($type['options']['maxlength'])
																			?$type['options']['maxlength']
																			:$type['size'])
																			)
											)
									);
					break;
				case 'BigText':
				case 'Email':
				case 'Phone':
				case 'CardNumber':
				default:
					$group->add(new HtmlTextInput($key,$attribute,__s(strtolower($entity->entityName),$key."_label",$key)));
					break;
				case 'Select':
					$group->add(new HtmlSelect(
										$key,
										$attribute,__s(strtolower($entity->entityName),$key."_label",$key),
										null,
										__(strtolower($entity->entityName),$key."_select_list_values",__('form','select_default_list',"-1:no options"))
										)
									);
					break;
				case 'Image':
				case 'File':
					$this->enctype="multipart/form-data";
					$group->add(new HtmlFileInput($key,$attribute,__s(strtolower($entity->entityName),$key."_label",$key)));
					break;
			}
		}
		$this->add($group);
		$this->addGroup('action', 
						array(
								new HtmlSubmitButton(
										__($entity->entityName,'save_button',"save"),
										__($entity->entityName,'save_button',"save"),
										"",
										array(
											'class'=>"button save", 
											'accesskey'=>"S",
											'title'=>__($entity->entityName,$key."_form_save","Click to save modification")
										)
								),
								new HtmlCancelButton(
										__($entity->entityName,'save_button',"cancel"),
										__($entity->entityName,'save_button',"cancel"),
										"",
										array(
											'class'=>"button cancel", 
											'accesskey'=>"C",
											'title'=>__($entity->entityName,$key."_form_cancel","Click to cancel operation")
										)
								)
						),
						__($entity->entityName,$this->action."_legend","actions for ".$this->action )		
					);
	}
	/*
	 * Add a group of COmponent (fieldset) to the form.
	 */
	public function addGroup($name,$components,$legend=""){
		$this->add(new HtmlGroup($name,$components,$legend));
	}
	
	public function serialize(){
		$html =  "<form method=\"".$this->method."\""
						." name=\"".(__isActive('system','')?"":"index.php?").strtolower($this->entity->entityName)."/".$this->action."/".$this->entity->id."\""
						." action=\"".$this->action."\""
						.($this->enctype!=""?" enctype=\"".$this->enctype."\"":"")
						.">";
		foreach($this->formComponents as $component){
			if($component instanceof HtmlComponent){
				$html.=$component->serialize($this);
			}
		}
		$html .= "</form>";
		return $html;
	}
} 
?>
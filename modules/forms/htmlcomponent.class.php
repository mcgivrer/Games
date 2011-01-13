<?php
/**
 * Default HTML component object.
 * all Html input would inherit from this object definition.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/24
 */
class HtmlComponent{
	
	public static $DEFAULT_TEMPLATE="<div class=\"attribute\"><span class=\"label\">{label}</span>{component}</div>";
	
	
	/*
	 * Internal object counter
	 */
	protected static $counter=0;
	protected $html ="";
	protected $htmlAttributes=array();
	protected $input="input";
	protected $type="text";
	protected $label="";
	protected $value="";
	protected $template="";
	protected $accesskey="";
	
	/**
	 * Default constructor.
	 * @param string $input
	 * @param string $type
	 * @param string $name
	 * @param string $label
	 * @param string $value
	 * @param array $htmlAttributes
	 * @param array $selectOptions
	 * @param string $defaultTemplate
	 */
	public function __construct(
				$input="input", 
				$type="text", 
				$name="",
				$value="",
				$label="",
				$htmlAttributes=null,
				$selectOptions=null,
				$defaultTemplate=""){
		__debug("HtmlComponent: $input, $type, $name,$label, $value", __METHOD__, __CLASS__);
		$this->htmlversion=__config('system','output_html_version','4');
		$this->counter++;
		$this->label=($label!=""?$label:$name);
		$this->input = $input;
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
		$this->htmlAttributes=$htmlAttributes;
		$this->selectOptions=$selectOptions;
		$this->template=($defaultTemplate!=""?$defaultTemplate:self::$DEFAULT_TEMPLATE);
	}
	
	public function setTemplate($template){
		$this->template = $template;
	}
	
	/**
	 * Serialize data.
	 * @param HtmlForm $form form object containing this component.  
	 */
	public function serialize($form=null){
		__debug("serialize HtmlComponent", __METHOD__, __CLASS__);
		// display label and input.
		$this->accesskey =  preg_replace('/([^*]*)\_([^?])([^*]*)/',' accesskey="\2"',$this->label);
		$this->label=preg_replace('/([^*]*)\_([^?])([^*]*)/','\1<span class="accesskey">\2</span>\3',$this->label);
		$accesskeyAttribute=false;
		$label = (isset($this->label) && $this->label!=""?"<label for=\"".$this->name."\">".$this->label."</label>":"");
		$component = "<".$this->input.($this->type!=""?" type=\"".$this->type."\"":"")
								.($this->name!=""?" name=\"".$this->name."\" id=\"".$this->name."\"":$this->type."_".self::$counter)."";
		$component .=" value=\"".$this->value."\"";
		if(isset($this->htmlAttributes)){
			foreach($this->htmlAttributes as $key=>$value){
				$component  .= " $key=\"$value\"";
				$accesskeyAttribute=($key=="accesskey");
			}
		}
		if(!$accesskeyAttribute){
			$component .= $this->accesskey;
		}
		if(strtolower($this->input)=="select" && $this->selectOptions!=null){
			$component  .= ">";
			foreach($this->selectOptions as $id=>$value){
				$component  .="<option value=\"$id\">".htmlentities($value,ENT_QUOTES,__config('system','data_encoding'))."</option>";
			}
			$component  .="</".$this->input.">";
		}else{
			$component  .= "/>";		
		}
		$this->html=str_replace(array("{label}","{component}"),array($label, $component),$this->template);
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
<?php
class Entity implements IEntity {

			
	protected $attributes=array(
		'id'=>"",
		'entityName'=>__CLASS__);
	
	protected $attributesCallBack = array();
	
	public function __construct($name){
		$this->attributes['entityName'] = $name;
	}
	
	/**
	 * Add a pre-treatment for a specific attribute.
	 * For example, switch to the translated value stored in the field (see the translate() method bellow).
	 * @param string $attribute
	 * @param method $callBackMethod
	 */
	public function addAttributeCallBack($attribute,$callBackMethod){
		$this->attributesCallBack[$attribute]=$callBackMethod;
	}

	/**
	 * Return the translate an attribute value according to the system/language value.
	 * @param string $attribute attribute name.
	 * @param string $value attribute value.
	 * @param string $language used if want specific language.
	 */
    public function translate($value, $attribute, $language=""){
    	//echo "<pre>attribute:$attribute, value=[$value], language:$language</pre>";
    	$sub=$value;
    	$langsub = __config('system','language',"en_EN");
    	$lang=explode('-',$langsub);
    	if(strstr($sub,"§")!=false){
	    	$values = explode('§',$value);
	    	foreach($values as $id=>$value){
	    		$sub = explode(':',$value);
	    		if($sub[0]==$lang[0]){
	    			//echo "<pre>lang: $lang[0], attribute -> '".print_r($sub[1],true)."'</pre>";
	    			$sub = $sub[1];
	    			break;
	    		}
	    	}
    	}
    	return $sub;
    }
	
	
	public function load($id,$data,$datamapping){
		$this->loadData($id,$data,$datamapping);
	}
	
	/**
	 * Load data into object.
	 * @see IEntity#load($uid,$data,$datamapping)
	 */
	public function loadData($id,$data,$datamapping,$attributeCallBack=null){
		$this->attributes['id'] = $id; 
		foreach($datamapping as $attribute){
			if($attribute!="" && $attribute !=null){
				if($attributeCallBack!=null && isset($attributeCallBack[$attribute])){
					$this->attributes[$attribute] = call_user_func(array($this,$attributeCallBack[$attribute]),$data[array_search($attribute,$datamapping)],$attribute);
				}else{
					$this->attributes[$attribute] = $data[array_search($attribute,$datamapping)];
				}
			}
		}
	}
	
	/**
	 * Return entity attribute <code>$attribute</code> decorated value
	 * @param string $attribute attribute name.
	 */
	public function getInfo($attribute="title"){
		if($attribute!="" && $attribute !=null){
			if($this->attributesCallBack!=null && isset($this->attributesCallBack[$attribute])){
				$value = call_user_func($this->attributesCallBack[$attribute],$this->attributes[$attribute],$attribute);
			}else{
				$value=$this->attributes[$attribute];
			}
			//echo "<pre>$attribute:$value</pre>";
			return "".$this->getDisplay($attribute,$value);
		}
	}
	
	/**
	 * Add or set an attribute <code>$attribute</code> to value <code>$value</code>.
	 * @param string $attribute
	 * @param object $value
	 */
	public function setAttribute($attribute,$value){
		$this->attributes[$attribute] = $value;
	}
	
	/**
	 * Return entity attribute <code>$key</code> value
	 * @param string $key attribute name.
	 */
	public function getAttribute($attribute="title"){
		return $this->attributes[$attribute];
	}
	
	/**
	 * @param string $attribute.
	 */
	public function getDisplay($attribute,$value){
		return $value;
	}
	
	public function serialize(){
		return implode('|',$this->attributes);
	}
}
<?php
class Entity implements IEntity {

			
	protected $attributes=array(
		'id'=>"",
		'entityName'=>__CLASS__);

	protected $attributesType=array(
		'id'=>array('type'=>"Text"),
		'entityName'=>array('type'=>"Text"));
	
	protected $attributesCallBack = array();
	
	public function __construct($name){
		$this->attributes['entityName'] = $name;
	}
	/**
	 * Add a new attribute to this object.
	 * @param string $attributeName name fo this attribute
	 * @param string/array $attributeType type of attribute can be a string with 
	 * type or an array with following attributes : 
	 *    array('type'=>"",'size'=>"",'options=>"");
	 */
	protected function addAttribute($attributeName, $attributeType){
		if(!isset($this->attributes[$attributeName])){
			$this->attributes[$attributeName]="";
			$this->attributesType[$attributeName]['type'] = $attributeType;
		}else{
			throw new Exception("Attribute $attributeName already set","90100");
		}
	}
		
	/**
	 * Add a bundle of attributes to this object.
	 * @param array $attributes list of attributes as :
	 *   array( 
	 *      array('name'=>"", 'type'=>"",'size'=>"",'options'=>""),
	 *      array('name'=>"", 'type'=>"",'size'=>"",'options'=>""),
	 *      array('name'=>"", 'type'=>"",'size'=>"",'options'=>""),
	 *      array('name'=>"", 'type'=>"",'size'=>"",'options'=>""),
	 *      ...
	 *      );
	 */
	protected function addAttributes($attributes){
		foreach($attributes as $attribute){
			if(!isset($this->attributes[$attribute['name']])){
				$this->attributes[$attribute['name']]="";
				$this->attributesType[$attribute['name']]['type'] = $attribute['type'];
				if(isset($attribute['size'])){
				$this->attributesType[$attribute['name']]['size'] = $attribute['size'];
				}
				if(isset($attribute['options'])){
					$this->attributesType[$attribute['name']]['options'] = $attribute['options'];
				}
			}else{
				throw new Exception("Attribute $attributeName already set","90100");
			}
		}
	}
	
	/**
	 * Return the value for attribute.
	 * e.g.: 
	 * - getName() will return the Attribute 'name' value.
	 * - getDecoratedName() will return the "Display" value of the attribute "name"
	 * 
	 * @param unknown_type $attribute
	 */
	public function __get($attribute){
		$decorated=false;
		if(strstr($attribute,'decorated_')!==false){
			$attribute = str_replace("decorated_","",$attribute);
			$decorated=true;
		}
		if(array_key_exists($attribute,$this->attributes)){
			// if decorated mode then call the getDisplay Method, else return attribute value.
			return ($decorated?$this->getDisplay($attribute,$this->attributes[$attribute]):$this->attributes[$attribute]);
		}else{
			$trace = debug_backtrace();
			trigger_error(
					'Undefined property via __get(): ' . $attribute .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
		}
	}

	public function __set($attribute,$value){
		if(array_key_exists($attribute,$this->attributes)){
			$this->attributes[$attribute]=$value;
		}else{
			$trace = debug_backtrace();
			trigger_error(
					'Undefined property via __set(): ' . $attribute .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
		}
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
    	$langsub = I18n::getInstance()->getLanguage();
    	$lang=explode('-',$langsub);
    	//print_r($lang);
    	if(strstr($sub,"\\")!=false){
	    	$values = explode('\\',$value);
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
	 * Load data from POST.
	 * @param $_POST $post content of the POST event from HTML form.
	 */
	public function loadFromPost($post){
		foreach($this->attributes as $key=>$attribute){
			switch($this->attributesType[$key]['type']){
				case 'Image':
					echo"<pre>this an image Object</pre>";
					break;
				case 'Text':
				case 'Password':
				default:
					$this->attributes[$key]=$post[$key];
					break;
			}
		}
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
					//$this->attributes[$attribute] = call_user_func(array($this,$attributeCallBack[$attribute]),$data[array_search($attribute,$datamapping)],$attribute);
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
	public function getAttribute($attribute="title",$language=""){
		if($language!=""){
			return $this->translate($this->attributes[$attribute],$attribute,$language);
		}
		return $this->attributes[$attribute];
	}
	
	/**
	 * @param string $attribute.
	 */
	public function getDisplay($attribute,$value){
		return $value;
	}
	
	public function getAttributes(){
		return $this->attributes;
	}
	public function getAttributeType($attributeName){
		return $this->attributesType[$attributeName];
	}
	
	/**
	 * return serialized value for this object.
	 */
	public function serialize(){
		return implode('|',$this->attributes);
	}
	
	/**
	 * Default compare implementation (based on serialized value).
	 * @param Entity $entity1
	 * @param Entity $entity2
	 */
	public function compare($entity1,$entity2){
    	$att1= $entity1->serialize();
    	$att2= $entity2->serialize();
        return self::compareAttribute($att1,$att2);
	}
	
	/**
	 * Internal Comparator for 2 string value.
	 * @param string $att1
	 * @param string $att2
	 */
	protected static function compareAttribute($att1,$att2){
    	if($att1==$att2){
    		return 0;
    	}else{
    		return (($att1 < $att2) ? -1 : 1);
    	}
	}
}
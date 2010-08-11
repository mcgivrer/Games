<?php
class Entity extends ImagesEntity  implements IEntity {

			
	protected $attributes=array(
		'id'=>"",
		'entityName'=>__CLASS__);
	
	public function Entity($name){
		parent::__construct();
		$this->attributes['entityName'] = $name;
	}
	
	/**
	 * Load data into object.
	 * @see IEntity#load($uid,$data,$datamapping)
	 */
	public function load($id,$data,$datamapping){
		$this->attributes['id'] = $id; 
		foreach($datamapping as $attribute){
			if($attribute!="" && $attribute !=null){
				$this->attributes[$attribute] = $data[array_search($attribute,$datamapping)];
			}
		}
	}
	
	/**
	 * Return entity attribute <code>$key</code> decorated value
	 * @param string $key attribute name.
	 */
	public function getInfo($key="title"){
		return "".$this->getDisplay($key);
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
	public function getDisplay($attribute){
		return $this->attributes[$attribute];
	}
	
	public function serialize(){
		return implode('|',$this->attributes);
	}
}
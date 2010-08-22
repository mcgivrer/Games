<?php
/**
 * Support entity.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/21
 */
class Support extends Entity implements IEntity {
	/**
	 * Default constructor for a User entity.
	 */
	public function __construct(){
    	$this->attributes	 = array(
    			'name'		=>"", 
    			'description'	=>"", 
    			'author'	=>"", 
    			'created_at'		=>"");
    	$this->attributesType= array(
    			'name'		=>"String", 
    			'description'	=>"String", 
    			'author'	=>"String", 
    			'created_at'		=>"Date");
    }
    /**
     * Default constructor.
     * @param string $id
     */
    public function Support($id){
    	parent::__construct(__CLASS__);
        $this->attributes['id']=$id;
    	__debug("Support.entityName=".$this->getInfo('entityName'),__METHOD__,__CLASS__);
    }
    
	public function getDisplay($attribute,$value){
	    	//echo "<pre>display: attr:$attribute, val:$value</pre>";
    	if(isset($this->attributes[$attribute])){
	    	switch($attribute){
	    		case 'name':
	    			return "".strtoupper("".$value);
	    			break;
	    		default:
	    			return "".$this->getAttribute($attribute);
	    			break;
	    	}
    	}else{
    		return "unknown attribute '$attribute'.";
    	}
	}
    
    public function compare($att1,$user2){
    	parent::compareAttribute($att1->getAttribute("name"),$att2->getAttribute("name"));
    }
}
?>
<?php
/**
 * User entity.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/15
 */
class User extends ImagesEntity implements IEntity {
	/**
	 * Default constructor for a User entity.
	 */
	public function __construct(){
    	$this->attributes	 = array(
    			'name'		=>"", 
    			'firstname'	=>"", 
    			'lastname'	=>"", 
    			'email'		=>"",
    			'password'	=>"",
    			'role'		=>"",
    			'avatar'	=>"");
    	$this->attributesType= array(
    			'name'		=>"String", 
    			'firstname'	=>"String", 
    			'lastname'	=>"String", 
    			'email'		=>"String",
    			'password'	=>"String",
    			'role'		=>"String",
    			'avatar'	=>"Image");
    }
    /**
     * Default constructor.
     * @param string $id
     */
    public function User($id){
    	parent::__construct(__CLASS__);
        $this->attributes['id']=$id;
    	__debug("Game.entityName=".$this->getInfo('entityName'),__METHOD__,__CLASS__);
    }
	/**
	 * Load data into object.
	 * @param array $data from file.
	 */    
    public function load($id, $data,$datamapping){
    	parent::loadData($id, $data,$datamapping);
    	$this->loadImages("name","avatar");
    	//print_r($this);
    }
    
	public function getDisplay($attribute,$value){
	    	//echo "<pre>display: attr:$attribute, val:$value</pre>";
    	if(isset($this->attributes[$attribute])){
	    	switch($attribute){
	    		case 'name':
	    			return "".ucfirst("".$value);
	    			break;
	    		case 'firstname':
	    			return "".ucfirst("".$value);
	    			break;
	    		case 'lastname':
	    			return "".ucfirst("".$value);
	    		default:
	    			return "".$this->getAttribute($attribute);
	    			break;
	    	}
    	}else{
    		return "unknown attribute '$attribute'.";
    	}
	}
    
    public function compare($user1,$user2){
    	$att1= $user1->getAttribute('name');
    	$att2= $user2->getAttribute('name');
        if($att1==$att2){
    		return 0;
    	}else{
    		return ($att1 < $att2) ? -1 : 1;
    	}
    }
}
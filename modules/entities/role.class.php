<?php
/**
 * Role entity.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/09/07
 */
class Role extends ImagesEntity implements IEntity {
	/**
	 * Default constructor for a Role entity.
	 */
	public function __construct(){
    	$this->addAttributes(array(
    					array('name'=>"name",'type'=>"Text",'size'=>"20",'value'=>""),
    					array('name'=>"description",'type'=>"Text",'size'=>"255",'value'=>""),
            			)
    				);
    }
    /**
     * Default constructor.
     * @param string $id
     */
    public function Role($id){
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
    }
    
	public function getDisplay($attribute,$value){
	    	//echo "<pre>display: attr:$attribute, val:$value</pre>";
    	if(isset($this->attributes[$attribute])){
	    	switch($attribute){
	    		case 'name':
	    			return "".ucfirst("".$value);
	    			break;
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
    	$this->compareAttribute($att1,$att2);
    }
}
?>
<?php
class Game extends ImagesEntity implements IEntity {
	/**
	 * Images stored with this object.
	 * @var unknown_type
	 */
	//protected $pictures=array('cover'=>array(),'screenshots'=>array(),'arts'=>array());
	
	protected $author = null;
	
    public function __construct(){
    	$this->attributes=array(
    			'id'=>"", 
    			'title'=>"", 
    			'support'=>"", 
    			'note'=>"",
    			'comment'=>"",
    			'author'=>"",
    			'tags'=>"");
        $this->attributesType=array(
    			'id'=>"Integer", 
    			'title'=>"String", 
    			'support'=>"String", 
    			'note'=>"String",
    			'comment'=>"String",
    			'author'=>"User",
    			'tags'=>"array");
        $this->addAttributeCallBack('title', array($this,'translate'));
        //$this->addAttributeCallBack('tags', array($this,'splitTags'));
    }
    
    /**
     * Default constructor.
     * @param string $id
     */
    public function Game($id){
    	parent::__construct(__CLASS__);
        $this->attributes['id']=$id;
    	__debug("Game.entityName=".$this->entityName,"Game",__CLASS__);
    }

    public function splitTags($value, $attribute, $language=""){
    	return explode(',',$value);
    }
    
    /**
     * return "display" formatted <code>$attribute</code> value.
     * @param $attribute
     */
    public function getDisplay($attribute,$value){
    	//echo "<pre>display: attr:$attribute, val:$value</pre>";
    	if(isset($this->attributes[$attribute])){
	    	switch($attribute){
	    		case 'title':
	    			return "".ucwords("".$value);
	    			break;
	    		case 'support':
	    			return "".strtoupper("".$value);
	    			break;
	    		case 'comment':
	    			return "".ucfirst("".$value);
	    		default:
	    			return "".$this->getAttribute($attribute);
	    			break;
	    		case 'tags':
	    			return explode(',',$value);
	    	}
    	}else{
    		return "unknown attribute '$attribute'.";
    	}
    }
    
    /**
     * Implementation of the comparator for uasort() call in Data process.
     * @param unknown_type $game1
     * @param unknown_type $game2
     */
    /*public function compare($game1,$game2){
    	$title1 = $game1->getAttribute('title');
    	$title2 = $game2->getAttribute('title');
    	
   		return self::compareAttribute($title1,$title2);
    }*/

    /**
     * Compare Game object on title attribute.
     * @param $game1
     * @param $game2
     */
    public function compareTitle($game1,$game2){
    	return self::compare($game1,$game2);
    }
    
    /**
     * Implementation of the comparator for uasort() call in Data process.
     * Specific implementation to sort on 'support' attribute.
     * @param unknown_type $game1
     * @param unknown_type $game2
     */
    public function compareSupport($game1,$game2){
    	$att1 = $game1->getAttribute('support');
    	$att2 = $game2->getAttribute('support');
		$state = self::compareAttribute($att1,$att2);
		//echo "$att1 / $att2 => $state<br/>"; 
    	return $state;
    }
}
?>
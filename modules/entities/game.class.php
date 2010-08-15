<?php
class Game extends ImagesEntity implements IEntity {
	/**
	 * Images stored with this object.
	 * @var unknown_type
	 */
	protected $pictures=array('cover'=>array(),'screenshots'=>array(),'arts'=>array());
	
    public function __construct(){
    	$this->attributes=array('id'=>"", 'title'=>"", 'support'=>"", 'note'=>"",'comment'=>"",'author'=>"");
        $this->addAttributeCallBack('title', array($this,'translate'));
    }
    
    /**
     * Default constructor.
     * @param string $id
     */
    public function Game($id){
    	parent::__construct(__CLASS__);
        $this->attributes['id']=$id;
    	__debug("Game.entityName=".$this->getInfo('entityName'),"Game",__CLASS__);
    }
    
	/**
	 * Load data into object.
	 * @param array $data from file.
	 */    
    public function load($id, $data,$datamapping){
    	parent::loadData($id, $data,$datamapping);
    	$this->loadImages("support/title","cover,arts,screenshots");
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
	    	}
    	}else{
    		return "unknown attribute '$attribute'.";
    	}
    }
    
    /**
     * Implemntation of the comparator for uasort() call in Data process.
     * @param unknown_type $game1
     * @param unknown_type $game2
     */
    public function compare($game1,$game2){
    	$title1 = $game1->getAttribute('title');
    	$title2 = $game2->getAttribute('title');
    	
    	if($title1==$title2){
    		return 0;
    	}else{
    		return ($title1 < $title2) ? -1 : 1;
    	}
    }
}
?>
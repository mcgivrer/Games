<?php 
class ApplicationManager extends PageManager{

	/**
	 * Call parent constructorto initialize default system.
	 */
	public function __construct($name, $params){
		__debug("Start",__METHOD__,__CLASS__);
		parent::__construct($name,$params);
	}
	
	public function search(){
		$search=__parameterSession('search',"",$this);
		__debug("Search for '$search' text",__METHOD__,__CLASS__);
		
		$results = $this->persistance->find('Game',"title=$search*");
		__debug("find ".count($search)." results",__METHOD__,__CLASS__);
		
		$this->addData('search',$results);
		$_SESSION['action']=null;
		
		return 'application/search';
	}
}
?>
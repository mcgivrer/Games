<?php
class GameManager extends ApplicationManager{
	
	/**
	 * Call parent constructor to initialize default system.
	 */
	public function __construct($name,$params){
		parent::__construct(__CLASS__,$params);
	}
	
	public function view(){
		__debug("retrieve gameId and populate game data.",__METHOD__,__CLASS__);
		$g = __parameterRequest('g',"1",$this,"session");
		$game = $this->persistance->getDataById($g);
		$this->addData('game',$game);
		return "view";
	}
	
}
?>
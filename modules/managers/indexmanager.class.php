<?php
class IndexManager extends PageManager{
	
	public function __construct(){
		parent::__construct(__CLASS__);
	}
	
	public function view(){
		__debug("retrieve params and populate data","view",__CLASS__);
		$g = __requestSession('g',"1");
		$s = __requestSession('s',"x360");
		__debug("display page id=$g","view",__CLASS__);
		
		$game = $this->persistance->getDataById($g);
						
		$games = $this->persistance->getDataFiltered('Game',
						array('id','title','support'),
						"support=".strtolower($s));
		
		$supports = $this->persistance->getDataListDistinct('Game','support');
		
		$this->addData('game',$game);	
		$this->addData('games',$games);
		$this->addData('supports',$supports);
		
		$this->addData('game_selected', $g);
		$this->addData('support_selected', $s);
		
		echo "<pre>game id=$g, support = $s</pre>";
		return "master";
	}
	
	public function create(){
		return "master";
		
	}
	/**
	 * Upload images
	 */
	public function upload(){
		echo"upload";
		$this->upload("support/title/");
		return "matser";
	}
	
	public function update(){
		return "master";
		
	}

	public function delete(){
		return "master";
		
	}
	
	public function getInstance(){
		parent::getInstance(__CLASS__);
		return self::$_instance;
	}
}

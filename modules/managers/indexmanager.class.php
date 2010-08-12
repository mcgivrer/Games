<?php
/**
 * Sample on how to use PageManager for simple display purpose.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
 */
class IndexManager extends PageManager{
	
	/**
	 * Call parent constructorto initialize default system.
	 */
	public function __construct(){
		parent::__construct(__CLASS__);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::view()
	 */
	public function view(){
		__debug("retrieve params and populate data","view",__CLASS__);
		$g = __requestSession('g',"1");
		$s = __requestSession('s',"x360");
		__debug("display page id=$g",__METHOD__,__CLASS__);
		
		$game = $this->persistance->getDataById($g);
						
		$games = $this->persistance->getDataFiltered('Game',
						array('id','title','support'),
						"support=".strtolower($s),
						array('limit'=>20));
		
		$supports = $this->persistance->getDataListDistinct('Game','support');
		
		$this->addData('game',$game);	
		$this->addData('games',$games);
		$this->addData('supports',$supports);
		
		$this->addData('game_selected', $g);
		$this->addData('support_selected', $s);
		$this->addData('size-screenshot',"180x120");
		
		//echo "<pre>game id=$g, support = $s</pre>";
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
	
	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::create()
	 */
	public function create(){
		return "master";
		
	}
	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::update()
	 */
	public function update(){
		return "master";
		
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::delete()
	 */
	public function delete(){
		return "master";
		
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::getInstance()
	 */
	public function getInstance(){
		parent::getInstance(__CLASS__);
		return self::$_instance;
	}
}
<?php
/**
 * Sample on how to use PageManager for simple display purpose.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/11
 */
class IndexManager extends ApplicationManager{
	
	/**
	 * Call parent constructor to initialize default system.
	 */
	public function __construct($name,$params){
		parent::__construct(__CLASS__,$params);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::view()
	 */
	public function view(){
		__debug("retrieve params and populate data","view",__CLASS__);
		$g = __parameterRequest('g',"1",$this,"session");
		$s = __parameterRequest('s',"x360",$this,"session");
		__debug("display page g=$g | s=$s",__METHOD__,__CLASS__);
		
		if($g==""){
			$g="".rand(1,20);
		}
		$game = $this->persistance->getDataById($g);
		$games = $this->persistance->getDataFiltered('Game',
						array('id','title','support'),
						"support=".strtolower($s),
						array('limit'=>20,'sort'=>"title asc"));
		$supports = $this->persistance->getData('Support');
		$past = array();
		for($i=0;$i<6;$i++){
			while(true){
				$rnd = rand(1,2000)/100;
				if(!array_search($rnd,$past)){
					$past[]=$rnd;
					break;
				}
			}
			$randomgames[$i]=$this->persistance->getDataById($rnd);		
		}
		/*print_r($randomgames);*/
		
		/*$supports = $this->persistance->getDataListDistinct(
				'Game','support',null,"compareSupport");*/
		
		$supports = $this->persistance->getData(
				'Support');
		
		$this->addData('game',$game);	
		$this->addData('games',$games);
		$this->addData('supports',$supports);
		$this->addData('randomgames',$randomgames);
		$this->addData('page-title',($g!=""?" - ".strtoupper($game->support." / ".ucfirst($game->title)) :""));
		$this->addData('game_selected', $g);
		$this->addData('support_selected', $s);
		$this->addData('size-screenshot',__config('resources','screenshot_size'));
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
		
		return $this->view();
		
	}
	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::update()
	 */
	public function edit(){
		return $this->view();
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::delete()
	 */
	public function delete(){
		
		return $this->view();
		
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/PageManager::getInstance()
	 */
	public static function getInstance(){
		parent::getInstance(__CLASS__);
		return self::$_instance;
	}
}
?>
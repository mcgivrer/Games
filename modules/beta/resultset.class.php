<?php
class ResultSet {
	private $meta = array();
	private $data = array();
	
	public function __construct(){
		$this->meta['index']=0;
		$this->meta['nextindex']=0;
		$this->meta['count']=0;
		$this->meta['offset']=0;
		$this->meta['pagesize']=-1; // no limit
	}
	
	/**
	 * Return number of records.
	 */
	public function getCount(){
		return $this->meta['count'];
	}
	/**
	 * store a value in the resultset.
	 * if $key is not set (=null) then an auto counter is used (in the metha['nextindex']
	 * to identify each item od the resultset.
	 * @param object $value
	 * @param string $key
	 */
	public function add($value,$key=null){
		if($key==null){
			$key=(isset($this->meta['nextindex'])?$this->meta['nextindex']:0);
			$key++;
			$this->meta['nextindex']=$key;
		}
		$this->meta['count']++;
		$this->data["".$key] = $value;
	}
	
	public function hasNext() {
		return ($this->meta['index']+1<$this->meta['count']);
	}
	public function next(){
		if($this->hasNext()){
			$this->meta['index']++;
			return $this->data[$this->meta['index']];
		}else{
			throw new Exception("No more data to parse in this ".__CLASS__, 10404);
		}
	}
	
	public function restart() {
		$this->meta['index']=0;
	}

	public function setMeta($key,$value){
		if(array_key_exists($key, $this->meta)){
			$this->meta[$key]=$value;
		}else{
			throw new Exception("THis meta data $key does not exists !", 10403);
		}
	}
}
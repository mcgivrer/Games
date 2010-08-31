<?php
class Data extends TData implements IData{
	
	private static $_indexes=array();

	public function Data(){

		$id=1;
		__debug("parse data directory","Data",__CLASS__);
		$rep=opendir(dirname(__FILE__)."/../data/");
		while($filename=readdir($rep)){
			if(
					$filename!=".." && 
					$filename!="." && 
					(strstr($filename,".txt")!=false || strstr($filename,".xml")!=false) 
			){

				// Extract entity name ($type) and file extension				
				$expltype = explode('s.',$filename);
				__debug("find data $filename to load into entity ".ucfirst($expltype[0]),"Data",__CLASS__);
				$entityName  = $expltype[0];
				$fileExtension =$expltype[1]; 
				self::$_data[$entityName]=array();
				switch ($fileExtension){
					case "txt":
						$id = $this->parseTxtFile($filename,$entityName,$id);
						break;
					case "xml":
						$id = $this->parseXmlFile($filename,$entityName,$id);
						break;
					default:
						throw new Exception("File type '".$fileExtension."' not known.");
				}
			}
		}
	}

	/**
	 * Parse a text file name with EntityName.txt
	 * @param $filename : the name of the file to read
	 * @param $entityName : name of entity to be instanciate with data.
	 **/
	private function parseTxtFile($filename, $entityName, $id=0){
		$entityUID=0;
		$file = @fopen(dirname(__FILE__)."/../data/".$filename,"r");
		if ($file) {
			__debug("find '$filename', generate entity(ies) for this file data","Data",__CLASS__);
			$line=0;
			while (!feof($file)) {
				$buffer = fgets($file);
				$line++;
				//__debug("retrieving data :". print_r($buffer,true),"Data",__CLASS__);
				if($line==1){
				$datamapping = preg_split("/[\s]*[|][\s]*/",$buffer);
				}else if($buffer!="" && !empty($buffer) && !strstr($buffer,"END")){
				$entityUID++;
				$data=preg_split("/[\s]*[|][\s]*/",$buffer);
					if(isset($data) && $data[0]!="END"){
					//__debug("Type identified : ".print_r($type,true),"Data",__CLASS__);
						$entity = new $entityName();
						$entity->$entityName($id);
						$entity->load($id, $data,$datamapping);
						self::$_data["".$entityName]["".$entityUID]= $entity;
						self::$_indexes[$id]=array($entityName,"".$entityUID);
					//__debug("Entity created for key (".self::$_indexes[$id][0]."/".self::$_indexes[$id][1]."):[".print_r($entity,true)."]","Data",__CLASS__);
					}
					$id++;
				}
			}
			fclose($file);
		}
		return $id;			
	}
	
	/**
	 * @see IData#getDataById($id)
	 */
	public function getDataById($id){
		__debug("retrieve data for id:".$id,"getDataById",__CLASS__);
		if(isset(self::$_indexes[$id])){
			$keys = self::$_indexes[$id];
			//echo "keys:(".print_r($keys,true).")<br/>";
			$data = $this->getData($keys[0],$keys[1]);
			//echo "retrieved:[".print_r($data,true)."]<br/>";
			return $data;
		}else{
			return null;
		}
	}
	
	/**
	 * Dynamic Method get[Entity]By[Attribute]($parameters) to retrieve Entity on an Attribute value. can return an array. 
	 * @param string $name Method's name
	 * @param string $parameters list of parameters
	 */
	public function __call($name,$parameters){
		__debug("retrieve data for ".$name."[parameters=".print_r($parameters,true)."]",__METHOD__,__CLASS__);
		$entity=null;
		if(strstr($name,"get")!==false){
			$analyse=explode(',',preg_replace('/get([^\*]+)By([^\*]+)/',"$1,$2",$name));
			//echo "<pre>$name=>".print_r($analyse,true)."</pre>";
			$entityName = $analyse[0];
			$entity =  $this->find($entityName,strtolower($analyse[1])."=".$parameters[0]);
		}
		return $entity;
	}
	
	/**
	 * @see IData#getData($entityName,$entityUID)
	 */
	public function getData($entityName="",$entityUID="",$options=null){
		__debug("GetData for ($entityName/$entityUID)","getData",__CLASS__);
		if($entityName=="" && $entityUID==""){
			$ret= self::$_data;
		}elseif($entityName != "" && $entityUID==""){
			$ret= self::$_data["".$entityName];
		}elseif($entityName != "" && $entityUID != ""){
			$ret= self::$_data["".$entityName]["".$entityUID];
		}else{
			$ret=null;
		}
		if(is_array($ret)){
			$ret = $this->manageOptions($entityName,$ret, $options);
		}
		__debug("returned data:[count=".count($ret)."]","getData",__CLASS__);
		return $ret;
	}

	/**
	 * Manage Options on data retrieving,like 'limit',...
	 * If 'limit' is set in the <code>$options</code> array, slice array for limit value.
	 * @param array $items to be optionized.
	 * @param array $options list of options to evaluate.
	 */
	private function manageOptions($entityName, $items, $options){
				// calculate number of items
		$count = count($items);
		$itemsOptionized = $items; 
		// manager options
		//print_r($options);
		if($options!=null){
			// If limit is set, slice array for limit value.
			if(isset($options['limit'])){
				__debug("limit=".$options['limit'],__METHOD__,__CLASS__);
				//echo 'limit:'.$options['limit'];
				$arrayOffset =(isset($items['meta']['array_offset'])?$items['meta']['array_offset']:0);
				if($count>$options['limit']){
					$itemsOptionized = array_slice($items, 0, $options['limit'],true);
				} 
				//$itemsOptionized['meta']['array_offset'] = $arrayOffset;
				//$itemsOptionized['meta']['array_page'] = $options['limit'];
			}
			if(isset($options['sort'])){
				__debug("sort:".$options['sort'],__METHOD__,__CLASS__);
				list($attribute,$direction) = explode(' ',$options['sort']);
				uasort($itemsOptionized,array($entityName,"compare".ucfirst($attribute)));
			}
		}
		//$itemsOptionized['meta']['array_count'] = $count;
		//print_r($itemsOptionized);
		return $itemsOptionized;		
	}
	
	/**
	 * @see IData#getDataDistinct($entityName,$distinctOnAttribute,$attributes=null,$sortCallBack=null)
	 */
	public function getDataListDistinct($entityName,$distinctOnAttribute,$attributes=null,$sortCallBack=""){
		$ret=array();
		foreach(self::$_data[$entityName] as $entity){
			if(!array_key_exists("".$entity->getInfo($distinctOnAttribute),$ret)){
				if($attributes==null){
					$ret["".$entity->getInfo($distinctOnAttribute)]=$entity;
				}else{
					$retItem=array();
					foreach($attributes as $attribute){
						$retItem[$attribute] = "".$entity->getInfo($attribute);
					}
					$ret["".$entity->getInfo($distinctOnAttribute)]=$retItem;
				}
			}
		}
		if($attributes==null){
			uasort($ret,array($entityName,($sortCallBack!=""?$sortCallBack:'compare')));
		}
		return $ret;
	}
	
	/**
	 * Prepare Array containing all condition to verify.
	 * @param $conditions
	 */
	private function analyzeConditions($conditions=""){
		$conditionsArray = array();
		//split string on ',' to separate conditions.
		if($conditions!=""){
			$conditionsItems=explode(",",$conditions);
			__debug("conditions item:[".print_r($conditionsItems,true)."]","analyzeConditions",__CLASS__);
			foreach($conditionsItems as $conditionItem){
				$split = preg_split('/([^\*]+)+([\<|\>|\=|\!\=])([^\*]+)/',$conditionItem,5,PREG_SPLIT_DELIM_CAPTURE);
				$conditionsArray[]=array('attribute'=>$split[1],'comparator'=>$split[2],'value'=>$split[3]);
			}
		}
		__debug("conditions array:[".print_r($conditionsArray,true)."]","analyzeConditions",__CLASS__);
		return $conditionsArray;
	}
	
	/**
	 * Verify if a list of condition for the $item.
	 * @param object $item
	 * @param array $conditions Array of string containing condition. 
	 */
	private function isConditionArrayTrue($item, $conditionsArray){
		if(count($conditionsArray)==0){
			return true;			
		}else{
			foreach($conditionsArray as $condition){
				//__debug("item:".print_r($item,true),"isConditionArrayTrue",__CLASS__);
				//__debug("condition:".print_r($condition,true),"isConditionArrayTrue",__CLASS__);
				//echo "<pre>".print_r($item,true)."</pre>";
				switch(trim($condition['comparator'])){
					case "=" :
						if(trim($item->getAttribute($condition['attribute']))==trim($condition['value'])){
							__debug("condition true for item(".$item->getAttribute('id').")","isConditionArrayTrue",__CLASS__);
							return true;
						}
						break;
					case "<":
						if($item->getAttribute($condition['attribute'])>$condition['value']){
							return true;
						}
						break;
					case ">":
						if($item->getAttribute($condition['attribute'])<$condition['value']){
							return true;
						}
						break;
				}
			}
			return false;
		}
	}
	
	/**
	 * Verify condition for one item.
	 * @param unknown_type $conditions
	 */
	private function verifyConditions($item, $conditions){
		return $this->isConditionTrue($item,$this->analyzeConditions($conditions));
	}
	
	/**
	 * Return an array of <code>$type</code> entity extract, with filtered list of <code>$attributes</code>
	 * @param string $type
	 * @param array of string $attributes list of attributes to be extracted from objects.
	 */
	public function getDataFiltered($entityName,$attributes=null,$conditions="",$options=null){
		__debug("retrieve all instance of $entityName and generate array with [".print_r(($attributes!=null?implode(',',$attributes):"null"),true)."]","getDataFiltered",__CLASS__);
		$ret=array();
		$conditionsArray = array();
		if($conditions!=""){
			$conditionsArray = $this->analyzeConditions($conditions);
		}
		// Filter record on condition.
		foreach(self::$_data[$entityName] as $key=>$item){
			if($this->isConditionArrayTrue($item,$conditionsArray) && $key!="meta"){
				$ret[$key]=$item;
			}
		}
		// Apply standard options
		if(is_array($ret) && $options!=null){
			$ret = $this->manageOptions($entityName,$ret, $options);
		}
		// Extract needed attributes if $attributes configured.
		$retFinal=array();
		if(is_array($attributes)){
			foreach($ret as $key=>$item){
				$retitem = array();
				foreach($attributes as $attribute){
					$retitem[$attribute] = "".$item->getInfo($attribute);
				}
				$retFinal[$key]=$retitem;
			}
		}else{
			$retFinal=$ret;
		}
		return $retFinal;
	}
	
	/**
	 * @see IData
	 * @param unknown_type $entityName
	 * @param unknown_type $conditions
	 * @param unknown_type $options
	 */
	public function find($entityName,$conditions=null,$options=null){
		return $this->getDataFiltered($entityName,null,$conditions,$options);
	} 
	
	public static function getInstance(){
		return parent::getSingletonInstance(__CLASS__);
	}
}
?>

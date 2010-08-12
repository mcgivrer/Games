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
				$entityName  = $expltype[0];
				$fileExtension =$expltype[1]; 
				self::$_data[$entityName]=array();
				switch ($fileExtension){
					case "txt":
						$this->parseTxtFile($filename,$entityName,$id);
						break;
					case "xml":
						$this->parseXmlFile($filename,$entityName,$id);
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
	}
	
	/**
	 * @see IData#getDataById($id)
	 */
	public function getDataById($id){
		__debug("retrieve data for id:".$id,"getDataById",__CLASS__);
		$keys = self::$_indexes[$id];
		//echo "keys:(".print_r($keys,true).")<br/>";
		$data = $this->getData($keys[0],$keys[1]);
		//echo "retrieved:[".print_r($mydata,true)."]<br/>";
		return $data;
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
			$ret = $this->manageOptions($ret, $options);
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
	private function manageOptions($items, $options){
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
				$itemsOptionized['meta']['array_offset'] = $arrayOffset;
				$itemsOptionized['meta']['array_page'] = $options['limit'];
			}
		}
		$itemsOptionized['meta']['array_count'] = $count;
		//print_r($itemsOptionized);
		return $itemsOptionized;		
	}
	
	/**
	 * @see IData#getDataDistinct($entityName,$distinctOnAttribute,$attributes=null)
	 */
	public function getDataListDistinct($entityName,$distinctOnAttribute,$attributes=null){
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
		//echo "<pre>data=".print_r($ret,true)."</pre>";
		if($attributes==null){
			uasort($ret,array($entityName,'compare'));
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
		foreach(self::$_data[$entityName] as $key=>$item){
			$retitem = array();
			if($this->isConditionArrayTrue($item,$conditionsArray) && $key!="meta"){
				//echo "<strong>item $key:</strong>[".print_r($item,true)."]<br/>";
				if(is_array($attributes)){
					__debug("Add item(".$item->getAttribute('id').") as array of attributes[$attributes]","getDataFiltered",__CLASS__);
					foreach($attributes as $attribute){
						$retitem[$attribute] = "".$item->getInfo($attribute);
					}
				}else{
					__debug("Add item(".$item->getAttribute['id'].") as object $entityname","getDataFiltered",__CLASS__);
					$retitem = $item;
				}
				$ret[$key]=$retitem;
			}
		}
		if(is_array($ret) && $options!=null){
			$ret = $this->manageOptions($ret, $options);
		}
		return $ret;
	}
	
	public static function getInstance(){
		return parent::getSingletonInstance(__CLASS__);
	}
}
?>

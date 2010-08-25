<?php
interface IData{
	/**
	 * Retrieve data from its unique ID.
	 * @param String $id
	 */
	public function getDataById($id);
	
	/**
	 * Retrieve Data from EntityName and it's Entity unique Id. 
	 * @param string $entityName
	 * @param string $entityUID
	 */
	public function getData($entityName="",$entityUID="");

	
	/**
	 * Return an array of <code>$type</code> entity extract, with filtered 
	 * list of <code>$attributes</code>. Additional conditions with string 
	 * <code>conditions</code> can be added to specify condition clause.
	 * sample condition: "support=psp" or "support=psp,title=Alan*".
	 * @param string $type
	 * @param array of string $attributes list of attributes to be extracted from objects.
	 * @param string $conditions liste of coma(,) separated conditions.
	 * @param array $options 'limit' and 'sort' options.
	 */
	public function getDataFiltered($entityName,$attributes=null,$conditions="",$options=null);
		
	/**
	 * Retrieve distinct data from EntityName on one attribute.
	 * $attributes would be an array listing attributes to be retrieved.
	 * $sortCallBack a sort method declared into the Entity to sort in a particular way the retrieved occurences.
	 * @param string $entityName
	 * @param string $distinctOnAttribute
	 * @param string $attributes
	 * @param method $sortCallBack
	 */
	public function getDataListDistinct($entityName,$distinctOnAttribute,$attributes=null,$sort=false);
	
	/**
	 * Search data into Entity  <code>$entityName</code> with the condition(s)
	 * defined into the <code>$conditions</code> array.
	 * Each entry in the conditions array will be :
	 *   $conditions = array( 'format'=>"title like %s", 'value'=>"MyValue" );
	 * Options about limit and sorting can be assed.
	 * @param string $entityName
	 * @param string $condition
	 * @param array $options
	 */
	public function find($entityName,$conditions=null,$options=null);
	
}
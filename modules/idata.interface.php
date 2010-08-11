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
	 * Retrieve distinct data from EntityName on one attribute.
	 * @param string $entityName
	 * @param string $distinctOnAttribute
	 * @param string $attributes
	 */
	public function getDataListDistinct($entityName,$distinctOnAttribute,$attributes=null);
	
	
	/**
	 * Singleton
	 */
	public static function getInstance();
}
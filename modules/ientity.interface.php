<?php
interface IEntity{
	/**
	 * Load Data from $data, respecting $datamapping with $id as unique Object ID
	 * @param string $uid
	 * @param array $data
	 * @param array $mapping
	 */
	public function load($uid,$data,$mapping);
	public function getDisplay($attribute);
}
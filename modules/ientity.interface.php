<?php
/**
 * Interface used to define an Entity.
 * @author Frédéric Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/08/15
 */
interface IEntity{
	/**
	 * Load Data from $data, respecting $datamapping with $id as unique Object ID
	 * @param string $uid
	 * @param array $data
	 * @param array $mapping
	 */
	public function load($uid,$data,$mapping);
	
	/**
	 * Decorate <code>$attribute</code> for display purpose.
	 * If you need to capitilize or camelcase string value, this is the way how to do.
	 * @param string $attribute attribute name to decorate
	 * @param string $value value of this attribute.
	 */
	public function getDisplay($attribute,$value);
	
	
	/**
	 * Compare implementation. must return an integer value, following the rules :
	 * * 0 => $entity1 = $entity2
	 * * 1 => $entity1 &gt; $entity2
	 * * -1 => $entity1 &lt; $entity2
	 * @param unknown_type $entity1
	 * @param unknown_type $entity2
	 */
	public function compare($entity1,$entity2);
}
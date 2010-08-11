<?php
class ConfigurationException extends Exception{
	public function __construct($message){
		parent::__construct($message);
	}
}
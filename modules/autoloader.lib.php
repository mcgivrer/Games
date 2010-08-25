<?php
/**
 *
 * @param string $className Class or Interface name automatically
 *			  passed to this function by the PHP Interpreter
 */
function autoLoader($className){
	//Directories added here must be 
//relative to the script going to use this file. 
//New entries can be added to this list
	$directories = array(
		'',
		'modules/',
		'modules/helpers/',
		'modules/entities/',
		'modules/managers/',
		'modules/patterns/',
		'modules/exceptions/',
		'modules/beta/',
		'application/entities/',
		'application/managers/'
		);

	//Add your file naming formats here
	$fileNameFormats = array(
		'%s.interface.php',
		'%s.pattern.php',
		'%s.class.php',
		'%s.manager.php',
		'%s.exception.php',
		'class.%s.php',
		'%s.php',
	);

	// this is to take care of the PEAR style of naming classes
	$path = str_ireplace('_', '/', $className);
	if(@include_once $path.'.php'){
		return;
	}
	
	foreach($directories as $directory){
		foreach($fileNameFormats as $fileNameFormat){
			$path = $directory.sprintf($fileNameFormat, strtolower($className));
			if(file_exists($path)){
				//echo "<pre>load $path</pre>";
				include_once $path;
				return;
			}
		}
	}
}

spl_autoload_register('autoLoader');
?>
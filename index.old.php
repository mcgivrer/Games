<?php
//echo "<pre>start</pre>";
require_once("modules/helpers.class.php");
__helpers("config");
__helpers("debug");
__helpers("i18n");
__helpers("template");

//echo "<pre>helpers done.</pre>";
session_start();

// cache rules management
Cache::getInstance()->addIncludeFilter("*");
Cache::getInstance()->addExcludeFilter("s=psp");
Cache::getInstance()->addExcludeFilter("upload");
//echo "<pre>cache initialized</pre>";

// Manage cache display
if(Cache::getInstance()->isExists()){
	//echo "<pre>get page from cache</pre>";
	__debug("cached page","index",__FILE__);
    Cache::getInstance()->getCachedPage();
}else{
	//echo "<pre>generate page</pre>";
    __debug("Generate page","index",__FILE__);
    Cache::getInstance()->start();
    //__debug("page data: ".print_r($page,true),"index",__FILE__);
    IndexManager::getInstance()->display();
    Cache::getInstance()->flush();
}
//echo "<pre>page done.</pre>";
?>
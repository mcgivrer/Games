<?php
	//Switch Theme
	Router::getInstance()->addRoute("theme/%t","index");
	//Search Engine
	Router::getInstance()->addRoute("search/%search","application");
	//User management
	Router::getInstance()->addRoute("user/%action/%name","user");

	//Default router	
	Router::getInstance()->setDefaultRoute("games/","index");
	
?>
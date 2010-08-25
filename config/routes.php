<?php
	//Router::getInstance()->addRoute("game/%g","index");
	Router::getInstance()->addRoute("game/%g/%action","index");
	Router::getInstance()->addRoute("games/%s","index");
	Router::getInstance()->addRoute("games/%s/%action","index");
	//Switch Theme
	Router::getInstance()->addRoute("theme/%t","index");
	Router::getInstance()->addRoute("search/%search","application");
	//User management
	Router::getInstance()->addRoute("user/%action","user");
	
	Router::getInstance()->setDefaultRoute("games/","index");
?>
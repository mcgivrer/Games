<?php
	//Router::getInstance()->setDefaultRoute("games/","index");

	Router::getInstance()->addRoute("game/%g/%action","index");
	Router::getInstance()->addRoute("games/%s","index");
	Router::getInstance()->addRoute("games/%s/%action","index");
	
?>
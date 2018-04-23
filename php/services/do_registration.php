<?php

	session_start();
	/*auto-load Classes*/
	spl_autoload_register(function ($class) 
	{
		require_once '../classes/' . $class . '.php';
	});
	
	$parentDao = new UserParentDao(DbConnection::getPDO());
	
	$parent = new UserParent($_POST['name'], $_POST['login'], $_POST['email'], $_POST['password']);
	
	$parentDao->createUserParent($parent);
?>
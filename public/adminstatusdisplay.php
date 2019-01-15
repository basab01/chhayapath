<?php
	include_once "../core/config/sop-init.inc.php";
	if ( $_SESSION['user'][0]['username'] === 'Admin' )
	{
		define ( 'APP_DIR', __DIR__ );
	
	
	
		error_reporting(E_ALL & ~E_NOTICE);
		
		include_once "assets/templates/adminStatusTemplate.php";
	}
	else
	{
		echo 'You are not allowed to view this page. <a href="login.php">Back</a>';
		exit();
	}
	
	
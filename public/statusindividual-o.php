<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	
	if ( isset ( $_SESSION['user'] ) )
	{
		error_reporting(E_ALL & ~E_NOTICE);
		$th = new Themes ( $dbo );
		$user = new User ( $dbo );
		$stype = $user -> selectSalonType ( $_SESSION['user'][0]['id'] );
		
		include_once "assets/templates/statusIndivTemplate.php";
	}
	else
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
	}
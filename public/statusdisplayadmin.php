<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );

	error_reporting(E_ALL & ~E_NOTICE);
	$flag = 0;
	
	if ( isset ( $_GET['token'] ) AND isset ($_GET['type']) )
	{
		if ( isset ( $_SESSION['admin'] ) AND ( $_GET['token'] == $_SESSION['admintoken'] ) )
		{
			$ttok = $_GET['token'];
			$typ = $_GET['type'];
			include_once "assets/templates/statusAdminTemplate.php";
		}
		else
		{
			$flag = 1;
		}
	}
	else
	{
		$flag = 1;
	}
	if ( $flag == 1 )
	{
		echo 'You have to login. Go to <a href="adminlogin.php">Login Page</a>';
	}
	
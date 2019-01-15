<?php
	include_once "../core/config/sop-init.inc.php";
	$flag = 0;
	
	if ( isset ( $_GET['token'] ))
	{
		if ( isset ( $_SESSION['admin'] ) AND ( $_GET['token'] == $_SESSION['admintoken'] ) )
		{
			$ttok = $_GET['token'];
			include_once "assets/templates/admindashboardtemplate.php";
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
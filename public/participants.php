<?php
	include_once "../core/config/sop-init.inc.php";
	
	define ( 'APP_DIR', __DIR__ );
	$flag = 0; $ttok = '';
	
	if ( isset ( $_GET['token'] ))
	{
		if ( isset ( $_SESSION['admin'] ) AND ( $_GET['token'] == $_SESSION['admintoken'] ) )
		{
			error_reporting(E_ALL & ~E_NOTICE);
			$ttok = $_SESSION['admintoken'];
			include_once "assets/templates/adminParticipantTemplate.php";
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
		echo 'You are not allowed to view this page. <a href="login.php">Back</a>';
		exit();
	}
	
	
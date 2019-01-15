<?php
	include_once "../core/config/sop-init.inc.php";
	if ( $_SESSION['user'][0]['username'] != 'Admin' )
	{
		echo 'You are not allowed to view this page. <a href="login.php">Back</a>';
		exit();
	}
	else
		include_once "assets/templates/adminSmsTemplate.php";
	
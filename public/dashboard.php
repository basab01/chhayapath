<?php
	include_once "../core/config/sop-init.inc.php";
	
	
	if ( isset ( $_SESSION['user'] ) )
	{
		include_once "assets/templates/dashboardTemplate.php";
	}
	else
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
	}
<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	
	if ( isset ( $_SESSION['user'] ) )
	{
		$th = new Themes ( $dbo );
		if ( isset ( $_GET['type'] ) ) $type = $_GET['type'];
		$stype = $th -> saltype ( $_GET['type'] );
		$sstype = $th -> saltype ( $_GET['type'] );
		include_once "assets/templates/SectionViewForm.php";
	}
	else
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
	}
<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	$th = new Themes ( $dbo );
	if ( isset ( $_GET['type'] ) ) $type = $_GET['type'];
	$sstype = $th -> saltype ( $_GET['type'] );
	
	$st = new Status ( $dbo );
	if ( $st -> checkConfirmation ( $idn, $sstype ) )
	{
		echo "Sorry, you don't have access to view this page. Go to <a href=\"dashboard.php\">Dashboard</a>";
		exit ();
	}
	
	
	include_once "assets/templates/imageViewForm.php";
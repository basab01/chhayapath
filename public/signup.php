<?php
	include_once "../core/config/sop-init.inc.php";
	
	
	if ( array_key_exists ( 'btnRegistration', $_POST ) )
	{	
		$regis = new Registration ( $dbo );
		$udtl = $regis -> registerUser ( $_POST );
		//print_r($udtl);
		//if ( isset ( $_SESSION['user'] ) ) unset ( $_SESSION['user'] );
		if ( !empty ( $udtl ))
		{
			$_SESSION['user'] = $udtl;
			header("Location:dashboard.php");
		}
		
	}
	
	
	include_once "assets/templates/signupTemplate.php";
<?php
	include_once "../core/config/sop-init.inc.php";
	
	
	if ( array_key_exists ( 'btnRegistration', $_POST ) )
	{	
		$regis = new Registration ( $dbo );
		$udtl = $regis -> changePassword ( $_POST );
		
		if ( $udtl )
		{
			$message = 'Password successfully updated';
			
		}
		
	}
	
	
	include_once "assets/templates/changePasswordTemplate.php";
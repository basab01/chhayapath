<?php
	include_once "../core/config/sop-init.inc.php";
	
	
	if ( array_key_exists ( 'btnRegistration', $_POST ) )
	{
		if ( $_SESSION['security_code'] == $_POST['sec_code'] )
		{
			$regis = new Registration ( $dbo );
			$udtl = $regis -> updateUser ( $_POST );
			echo $udtl . ' and id : '. $_SESSION['user'][0]['id'];
			
			if ( $udtl )
			{
				//$_SESSION['user'] = $udtl;
				 $user = new User( $dbo );
				 $mdata = $user->updatedUserProfile ( $_SESSION['user'][0]['id'] );
		         $_SESSION['user'] = $mdata;
				
				header("Location:dashboard.php");
			}
			else
			{
				echo 'Something Wrong!';
			}
		}
		else
		{
			$msg = 'Try Again !';
		}
		
	}
	
	include_once "assets/templates/updateTemplate.php";
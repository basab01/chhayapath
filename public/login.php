<?php

	include_once "../core/config/sop-init.inc.php";
	if ( $_POST )
	{
		if ( !preg_match ("/^chpthadmn/",$_POST['email'] ) )
		{
			$user = new User( $dbo );
			$mdata = $user->loginCheck ( $_POST );
			
			
			if ( !empty ( $mdata ))
			{
				$_SESSION['user'] = $mdata;
				header("Location:dashboard.php");
			}
			else
			{
				echo "Something wrong!!";
			}
		}
		else
		{
			$admin = new Admin ( $dbo );
			$admin_data = $admin->adminCheck ( $_POST );
			$_SESSION['user'] = $admin_data;
			header("Location:admin.php");
		}
	}
	include_once "assets/templates/loginForm.php";
	
<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );

	error_reporting(E_ALL & ~E_NOTICE);
	$flag = 0;
	
	if ( isset ( $_GET['token'] ))
	{
		if ( isset ( $_SESSION['admin'] ) AND ( $_GET['token'] == $_SESSION['admintoken'] ) )
		{
			$ttok = $_GET['token'];
			$userid = $_GET['usrid'];
			$type = $_GET['type'];
			$page = htmlspecialchars ( $_SERVER['PHP_SELF'] ).'?type='.$type.'&token='.$ttok.'&usrid='.$userid;
			$prvpage = 'statusdisplayadmin.php?type='.$type.'&token='.$ttok.'&usrid='.$userid;
			//echo $page;
			
			if ( $_POST )
			{
				if ( $_SESSION['security_code'] != $_POST['sec_code'] )
				{
					$msg = '<span style="color:red;">Try again!!</span> <a class="btn btn-primary" href="'.$prvpage.'">Back</a>';
				}
				else
				{
					$st = new Status ( $dbo );
					if ( $st->checkUser( $_GET['usrid'] ) > 0 )
					{
					$ss = $st->updatePaymentStatus($_GET['usrid'], $_POST);
					//echo 'value : '.$ss.'<br />';
					if ( $ss == 1 ) $msg = '<span style="color:green;">Update Successful !!</span> <a class="btn btn-primary" href="'.$prvpage.'">Back</a>';
					}
					else
					{
						$msg = '<span style="color:red;">Member needs to confirm first.</span> <a href="'.$page.'">Back</a>';
					}
				}
				
				
				if ( empty( $_POST['salonType'] ))
				{
					$msg = '<span style="color:red;">You must select Payment Status.</span> <a href="'.$page.'">Back</a>';
				}
				
			}
			include_once "assets/templates/adminupdatetemplate.php";
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
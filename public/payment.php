<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
		
		if ( isset ( $_SESSION['user'] ) )
		{
			error_reporting(E_ALL & ~E_NOTICE);
			
			
			
			if ( array_key_exists ( 'btnRegistration', $_POST ) )
			{
				//if ( $_SESSION['security_code'] == $_POST['sec_code'] )
				//{
					$regis = new Registration ( $dbo );
					$udtl = $regis -> insertPayDetails ( $_SESSION['user'][0]['id'], $_POST );
					//echo $udtl . ' and id : '. $_SESSION['user'][0]['id'];
					
					if ( $udtl )
					{
						//$_SESSION['user'] = $udtl;
						$msg = 'Thank you for submitting Bank Details.';
						//header("Location:dashboard.php");
					}
					else
					{
						echo 'Something Wrong!';
					}
				//}
				/*else
				{
					$msg = 'Try Again !';
				}*/
				
			}
			
			$str = '';
			if ( isset ( $_GET['msg'] ))
			{
				$str = '<center><div class="uploadTable"><h2 style="color:red;margin:12% 0 0 0;">'.$_GET['msg'].'</h2>';
				$str .= '<a href="dashboard.php">Dashboard</a></div></center>';
				//echo $str;
				
			}
			
			
			include_once "assets/templates/paymentTemplate.php";
		}
		else
		{
			echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		}
	
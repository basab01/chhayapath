<?php
	include_once "../core/config/sop-init.inc.php";
	if ( $_SESSION['user'][0]['username'] != 'Admin' )
	{
		echo 'You are not allowed to view this page. <a href="login.php">Back</a>';
		exit();
	}
	else
	{
		function send_sms($base_url,$post_fields) {
			$ch = curl_init();
			//echo $sms_massage;
			curl_setopt($ch, CURLOPT_URL,$base_url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			return $server_output;
		}
		$flag = 0;
		if ( array_key_exists ( 'sub', $_POST ) )
		{
		
			
		
		
		
		
			$msg = htmlspecialchars ( $_POST['getsms'] );
			$type = $_POST['res'];
			$mobs = '';
			if ( $type == 'all')
			{
				$ss = new Sms ( $dbo );
				$list = $ss -> selectPerson ();
				$jj = [];
				
				foreach ( $list as $key => $val )
				{
					$jj[] = $val[1];
				}
				$mobs = implode ( "\r\n", $jj );
				
			}
			else
			{
				$mobs = trim($_POST['getmobs']);
			}
			
			
			
			$username = 'Lakshmip';
			$pass = 'e)4Ti(9I';
			
			$mob = []; $smob = [];
			$mobs1='';
			$senderid = 'photonet.in';
			$mob = explode ( "\r\n", $mobs );
			
			
			
			
			
			
			
			
			if ( !empty($mob) && count($mob) > 1 )
			{
				foreach ( $mob as $v )
				{
					$v = '91'.$v;
					$smob[] = $v;
				}
				$mobs1 = implode ( ',', $smob );
				
			} 
			else
			{
				$mobs1 = '91'.$mobs;
				$smob[] = $mobs1;
				
				
			}
			
			foreach ( $smob as $m )
			{
			
				
				$kk = "http://api.infoSkysolution.com/SendSMS/sendmsg.php?uname=$username&pass=$pass&send=$senderid&dest=$m&msg=".urlencode($msg);
				$output = file_get_contents($kk);				
				$report =substr(trim($output),0,5);
				
				
				if($report == '0x200'||$report == '0x201'||$report == '0x202'||$report == '0x203'||$report == '0x204'||$report == '0x205'||$report == '0x206'||$report == '0x207'||$report == '0x208'||$report == '0x209'||$report == '0x210'||$report == '0x211'||$report == '0x212'||$report == '0x213')
				{
					$umsg = "ERROR !! SMS could not be sent";
					$flag = 2;
				}
				else
				{
					$umsg = "SMS Sent Successfully";
					$flag = 1;
				}
				
			}
			
			
				
		}
		include_once "assets/templates/adminFormSmsTemplate.php";
	}
	
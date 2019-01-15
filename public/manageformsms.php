<?php
	include_once "../core/config/sop-init.inc.php";
	if ( $_SESSION['user'][0]['username'] != 'Admin' )
	{
		echo 'You are not allowed to view this page. <a href="login.php">Back</a>';
		exit();
	}
	else
	{
		$ss = new Sms ( $dbo );
		$flag = false;
		$edt = 0;
		if(isset ( $_GET['edit'] ) )
		{
			$editid = intval ( $_GET['edit'] );
			$flag = true;
			
			$data = $ss->selectPerson( $editid );
		}
		if ( array_key_exists ( 'sub', $_POST ) )
		{
			if ( isset ( $_POST['personid'] ) )
			{
				$id = $_POST['personid'];
				$edt = 1;
			}
			if ( !empty($_POST['cname']) AND !empty($_POST['cmobile']) )
			{
				$_POST['cname'] = htmlspecialchars ( $_POST['cname'] );
				$_POST['cmobile'] = htmlspecialchars ( $_POST['cmobile'] );
			
			
				if ( $edt == 1 )
				{
					$lastid = $ss->updatePerson ( $id, $_POST );
					
				}
				else
				{
					$lastid = $ss->addPerson ( $_POST );
				}
				if ( $lastid > 0 )
				{
					$msg = "Data added. Last ID : $lastid";
					$msg = urlencode($msg);
				}
				else if ( $lastid == -1 )
				{
					$msg = "Data updated.";
					$msg = urlencode($msg);
				}
			}
			else
			{
				$msg = "You must provide Name and Mobile No.";
				$msg = urlencode($msg);
			}
			
			header("Location: manageformsms.php?message=$msg");
			
			
		}
		include_once "assets/templates/manageFormSmsTemplate.php";
	}
	
<?php

	include_once "../core/config/sop-init.inc.php";
	$flag = 0;
	
	if ( isset ( $_SESSION['user'] ) )
	{
		$flag = 1;
	}
	else
	{
		header("Location:login.php");
		exit();
	}
	
	if ( array_key_exists('btnLogin', $_POST ) AND $flag == 1 )
	{
		if(isset($_POST['sec_code']) AND isset ( $_SESSION['security_code'] ))
		{
			if($_POST['sec_code'] != $_SESSION['security_code']){
				$error[]="Try Again !!";
				$flag=1;
			}
			else
			{
				$cm = new Comment ( $dbo );
				$coms = $cm->insertComment ( $_SESSION['user'][0]['id'], $_POST );
				//echo 'last insert id : '.$coms;
				if ( $coms > 0 )
				{
					$comment = [];
					$comment = $cm->getComments($coms);
					$mes = '';
					$mes .= 'Name : '.$comment[0]['name']."\n\n";
					$mes .= 'Email : '.$comment[0]['email']."\n\n";
					$mes .= $comment[0]['comment'];
					$mes .= '\n\n';
					//echo $mes;
					include "mail1.php";
					//header("Location:comments.php");
				}
				
			}
		}
		
		
		
	}
	
	
	
	include_once "assets/templates/contactusTemplate.php";

?>
	
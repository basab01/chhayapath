<?php
	include_once "../core/config/sop-init.inc.php";
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	error_reporting(E_ALL & ~E_NOTICE);
	$idn = $_SESSION['user'][0]['id'];
	$country = $_SESSION['user'][0]['country'];
	$cur_id = 0; $pay = [];
	if ( $_SESSION['user'][0]['country'] == 'India' )
	{
		$cur_id = 3;
	}
	else
	{
		$cur_id = 1;
	}
	$flag = 0;
	
	if ( isset ( $idn ) )
	{
		$im = new Images ( $dbo );
		$num = $im -> checkImage ( $idn );
		if ( !$num > 0 ) $flag = 1;
	}
	
	
	if ( isset ( $_GET['type'] ) && $flag == 0 )
	{
		$get_type = $_GET['type'];
		
		$ss = new Status ( $dbo );
		$total = $ss -> displayPaymentStatus ();
		
		$pay['total'] = $total;
		$pay['currency'] = $cur_id;
		
		$k = $ss -> confirmSubmit ( $idn, $_GET['type'], $pay );
		
		if ( $k )
			include_once "assets/templates/confirmTemplate.php";
		else
		{
			echo 'Can not process.Go to <a href="dashboard.php">Dashboard</a>';
			exit ();
		}
		
	}
	if ( $flag == 1 )
	{
		echo '<center><p style="font-size:1em;color:red;margin:10% 0 0 0;">You must upload first. Go to <a href="dashboard.php">Dashboard</a></p></center>';
		exit ();
	}
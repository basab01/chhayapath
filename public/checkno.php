<?php
	include_once "../core/config/sop-init.inc.php";
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	$image = new Images ( $dbo );
	$getImg = [];
	$getImg = $image->selectPerUser ( $_GET['themeid'] );
	echo json_encode ( $getImg );
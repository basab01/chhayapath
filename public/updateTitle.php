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
	$status = '';
	$gg = [];
	$getImg = $image->updateImgTitle ( $_GET['imgid'], urldecode ( $_GET['title'] ) );
	if ( $getImg == 1 )
	{
		$status = 'Success';
	}
	else
	{
		$status = 'Fail';
	}
	$gg[] = array('status' => $status );
	echo json_encode ( $gg );
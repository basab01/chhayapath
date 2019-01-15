<?php
	include_once "../core/config/sop-init.inc.php";
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	
	$image = new Images ( $dbo );
	$gtImg = [];
	$status = '';
	$gg = [];
	$result = $image -> selectImage ( $_GET['imid'] );
	
	$gtImg = $image->imageDelete ( $_GET['imid'], $_GET['themeid'], $_GET['salonType'] );
	if ( $gtImg == 1 )
	{
		$status = 'Success';
		$idn = $_SESSION['user'][0]['id'];
		unlink ( 'assets/files/'.$_GET['salonType'].'/R-'.$idn.'/'.$result[0]['name'] );
	}
	else
	{
		$status = 'Fail';
	}
	$gg[] = array('status' => $status );
	echo json_encode ( $gg );
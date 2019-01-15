<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	$tid = intval ( $_GET['themeid'] );
	
	$image = new Images ( $dbo );
	$getImgs = [];
	$mmi = [];
	$getImgs = $image->selectImages ( $tid );
	
	foreach ( $getImgs as $imgs )
	{
		$mmi[] = array ('tid' => $tid, 'id' => $imgs['id'], 'name' => $imgs['name'], 'title' => $imgs['title'] );
	}
	echo json_encode ( $mmi );
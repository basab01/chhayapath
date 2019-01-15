<?php
	include_once "../core/config/sop-init.inc.php";
	
	/*if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	*/
	$file = fopen("../Cell.csv","r");
	$kk = [];
	while(! feof($file))
	{
		$kk[] = fgetcsv($file);
	}
	fclose($file);
	foreach ( $kk as $v )
	{
		//print 'Name :'.$v[0].' and Mobile :'.$v[1]."<br />";
		$sql = 'insert into addressbook values (Null, "'.$v[0].'", "'.$v[1].'", Null)';
		$result= $dbo->query($sql);
		print 'Result : '.$result.'<br />';
	}
	
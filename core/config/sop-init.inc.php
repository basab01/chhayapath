<?php
session_start();
ob_start ();
	if(!isset($_SESSION['token']))
	{
		$_SESSION['token'] = sha1(uniqid(mt_rand(),TRUE));
	}
	include_once "db-cred.inc.php";

	$dbo = new mysqli($bb['db_host'],$bb['db_user'],$bb['db_pass'],$bb['db_name']);
	
        $title = "19th Chhayapath International Salon 2018" ;
        $salon_name = " Chhayapath International Salon " ;
		$dashboard_heading = $title;
        $salon_year = 2018;
		
		$fip  = 'FIP/33/2018';
		$psa  = 'PSA 2018-205';
		$fiap = 'FIAP/2018/368';
		$gpu = '';
		$iup = 'IUP 2018-015';
	
	function __autoload($class)
	{
		$filename = "../core/class/class.".strtolower ( $class ).".php";
		if(file_exists($filename))
		{
			include_once $filename;
		}
	}
	
	define ( 'MAX_IMAGE_WIDTH', 1920 );
	define ( 'MAX_IMAGE_HEIGHT', 1080 );
<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	
	
		error_reporting(E_ALL & ~E_NOTICE);
		/*$th = new Themes ( $dbo );
		if ( isset ( $_GET['type'] ) ) $type = $_GET['type'];
		$stype = $th -> saltype ( $_GET['type'] );
		$sstype = $th -> saltype ( $_GET['type'] );*/
		include_once "assets/templates/statusTemplate.php";
	
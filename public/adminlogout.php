<?php
	include_once "../core/config/sop-init.inc.php";
	unset ( $_SESSION['admin'] );
	unset ( $_SESSION['admintoken'] );
	include_once "assets/templates/adminLogoutTemplate.php";
	
	
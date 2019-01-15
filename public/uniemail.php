<?php
	include_once "../core/config/sop-init.inc.php";
	
	
	if ( isset ( $_POST['txtEmail'] ) )
	{
		$query = 'select fname from registrant where eml_login="'.$_POST['txtEmail'].'"';
		$result = $dbo->query ( $query );
		if ( $result->num_rows > 0 )
		{
			$response = array(
				'valid' => false,
				'message' => 'This email is already registered'
			);
		}
		else
		{
			$response = array(
				'valid' => true
			);
		}
		
		echo json_encode ( $response );
	}
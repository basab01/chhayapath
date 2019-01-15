<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	if ( !isset ( $_SESSION['user'] ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	$idn = $_SESSION['user'][0]['id'];
	if ( empty ( $_POST['themeid']) OR empty ( $_POST['saltyp']) OR empty ($_POST['title']))
	{
		echo 'Some required fields are empty. Go to <a href="dashboard.php">Dashboard</a> and start again';
		exit ();
	}
	if ( strlen ( $_POST['title'] ) > 35 )
	{
		echo 'Title must be within 35 chars. Go to <a href="dashboard.php">Dashboard</a> and start again';
		exit ();
	}
	if ( preg_match("/No Title/i", $_POST['title'] ) )
	{
		echo '"No Title" is not a valid title. Go to <a href="dashboard.php">Dashboard</a> and start again';
		exit ();
	}
	$sstype = $_POST['saltyp'];
	
	$th = new Themes ( $dbo );
	$stype = $th -> saltype ( $sstype );
	
	$output_dir = APP_DIR . '/assets/files/'.$stype.'/R-'.$idn . '/';
	
	$user = new User( $dbo );
	$date = new Datetime ( 'Asia/Kolkata' );
	
	$image = new Images ( $dbo );
	
	$valid = new Validation ( $dbo );
	
	$flag = 0;
	
	
	
	if(isset($_FILES["myfile"]))
	{
		$file_info = getimagesize ( $_FILES["myfile"]["tmp_name"] );
		$width = $file_info[0]; $height = $file_info[1];
		
		if ( $width > MAX_IMAGE_WIDTH  OR $height > MAX_IMAGE_HEIGHT )
		{
			//$flag = 1;
		}
		
		if ( exif_imagetype($_FILES["myfile"]["tmp_name"]) != IMAGETYPE_JPEG )
		{
			$flag = 1;
		}
		
		if( $_FILES["myfile"]["size"] > 1572864 )
		{
				//$flag = 1;
		}
		
		
		
		if (! is_dir(APP_DIR . '/assets/files/'.$stype.'/R-'.$idn))
		{			
			mkdir(APP_DIR . '/assets/files/'.$stype.'/R-'.$idn);
		}
		
		if(!is_array($_FILES["myfile"]["name"]))
		{
			$fileName = $_FILES["myfile"]["name"];
			$fileName1 = preg_replace ( "/[^\w\.]/", '', $fileName );
			$fileName1 = htmlspecialchars($fileName1,ENT_QUOTES);
			
			if ( strlen( $fileName1 ) > 36 ) $flag = 1;
			if ( $image -> duplicateImgName ( $idn, $fileName1 ) > 0 )
				$flag = 11;
			$title = $valid->inputCheck ( $_POST['title'] );
			if ( $image -> checkDuplicateTitle ( $idn, $_POST['themeid'], $title ) > 0 )
				$flag = 1;
			$newName = $image -> nwFileName ( $_POST['themeid'], $_POST['saltyp'] );
		}
		
		
		if ( $flag != 1 AND $flag != 11 )
		{
			$lastid = $image->insertData ( array (
				'theme_id'=>$_POST['themeid'],
				'user_id'=>$idn,
				'name'=>''.$fileName1.'',
				'new_name' => ''.$newName.'',
				'title'=>''.$title.'',
				'active'=>0,
				'status' => 0,
				'modified'=>$date->format('Y-m-d H:i:s')
			));
		
		
			if ( isset ( $lastid ) AND $lastid > 0 )
			{
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName1);
				$ret[]= $fileName1;
				$flag = 2;
			}
			
			if ( $flag == 2 )
			{
				$rs = $image -> setImgActive ( $idn, $lastid );
				echo json_encode ( $ret );
			}
		}
		else
		{
			if ( $flag == 11 )
			{
				echo 'Image already exists !!';
			}
			else
				echo "Something Wrong !! Check File-name, File-type, Title or image width / height";
		}
	}
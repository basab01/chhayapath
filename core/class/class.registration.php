<?php

	class Registration extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		public function updateUser ( $data = [] )
		{
			$mlist = ["salutation" => "cmbSalutation",
						"fname" => "txtFirstname",
						"mname" => "txtMiddleName",
						"lname" => "txtLastName",
						"honour" => "txtPhotoHonour",
						"club" => "txtPhotoClub",
						"addr1" => "txtAddrLine1",
						"addr2" => "txtAddrLine2",
						"addr3" => "txtAddrLine3",
						"city_town_vill" => "txtCity",
						"state_province" => "txtState",
						"zipcode" => "txtZip",
						"country" => "cmbCountry",
						"salontype_id" => "salonType", 
						"eml_login" => "txtEmail",
						"mobile" => "txtMobile",
					];
			
			$valid = new Validation ( $this->db );
			
			$data['txtFirstname'] = $valid -> inputCheck ( $data['txtFirstname'] );
			$data['txtLastName'] = $valid -> inputCheck ( $data['txtLastName'] );
			$data['txtAddrLine1'] = $valid -> inputCheck ( $data['txtAddrLine1'] );
			$data['txtCity'] = $valid -> inputCheck ( $data['txtCity'] );
			$data['txtState'] = $valid -> inputCheck ( $data['txtState'] );
			$data['txtZip'] = $valid -> inputCheck ( $data['txtZip'] );
			
			
			if (empty($data['txtFirstname']) OR empty($data['txtLastName']) OR empty($data['txtAddrLine1']) OR empty($data['txtCity']) OR empty($data['txtState']) OR empty($data['txtZip']))
			{
				$error[] = "Please check the required fields. <a href='signup.php'>Back</a>";
				echo "Please check the required fields. <a href='profileUpdate.php'>Back</a>";
				exit ();
			}
			else if ( empty ( $data['cmbCountry'] ) )
			{
				$error[] = "You must select a country! <a href='signup.php'>Back</a>";
				echo "You must select a country! <a href='profileUpdate.php'>Back</a>";
				exit ();
			}
			else if ( empty ( $data['salonType'] ) )
			{
				/*$error[] = "You must select a section! <a href='signup.php'>Back</a>";
				echo "You must select a section! <a href='profileUpdate.php'>Back</a>";
				exit ();*/
				$data['salonType'] = 2;
			}
			
			
			if ( $valid -> emailCheck ( $data["txtEmail"] ) != True )
			{
				$error[] = "Check Your Email !";
				exit ();
			}
			
			else
			{
			
			/*$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');*/
			$id = NULL;
			$active = 1;
			
			
			$query = "update registrant set ";
			$str = []; $mst = '';
			foreach ( $mlist as $key=>$val )
			{
				$str[] = "`".$key."` = ?";
			}
			
			$mst = implode ( ', ', $str );
			
			$query .= $mst;
			$query .= ' where rgt_id = '.$_SESSION['user'][0]['id'];
			
			
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			$stmt->bind_param ( 
								'ssssssssssssiiss', 
								$data["cmbSalutation"], 
								strtoupper ( $data["txtFirstname"] ), 
								strtoupper ( $data["txtMiddleName"] ), 
								strtoupper ( $data["txtLastName"] ), 
								strtoupper ( implode (',', $data["txtPhotoHonour"] ) ),
								strtoupper ( $data["txtPhotoClub"] ),
								strtoupper ( $data["txtAddrLine1"] ),
								strtoupper ( $data["txtAddrLine2"] ),
								strtoupper ( $data["txtAddrLine3"] ),
								strtoupper ( $data["txtCity"] ),
								strtoupper ( $data["txtState"] ),
								$data["txtZip"],
								$data["cmbCountry"],
								$data["salonType"], 
								$data["txtEmail"], 
								$data["txtMobile"]
							);
			if (!$stmt->execute())
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			else
				return True;
			
			}
			
			
			
			//======================
			/*
			$valid = new Validation ( $this->db );
			if ( $valid -> emailCheck ( $data["txtEmail"] ) != True )
			{
				$error[] = "Check Your Email !";
				exit ();
			}
			else
			{
			*/
			
			/*$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');*/
			/*
			$id = NULL;
			$active = 1;
			
			
			$query = "update registrant set ";
			$str = []; $mst = '';
			foreach ( $mlist as $key=>$val )
			{
				$str[] = "`".$key."` = ?";
			}
			
			$mst = implode ( ', ', $str );
			
			$query .= $mst;
			$query .= ' where rgt_id = '.$_SESSION['user'][0]['id'];
			
			
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			$stmt->bind_param ( 
								'ssssssssssssiiss', 
								$data["cmbSalutation"], 
								$data["txtFirstname"], 
								$data["txtMiddleName"], 
								$data["txtLastName"], 
								$data["txtPhotoHonour"],
								$data["txtPhotoClub"],
								$data["txtAddrLine1"],
								$data["txtAddrLine2"],
								$data["txtAddrLine3"],
								$data["txtCity"],
								$data["txtState"],
								$data["txtZip"],
								$data["cmbCountry"],
								$data["salonType"], 
								$data["txtEmail"], 
								$data["txtMobile"]
							);
			if (!$stmt->execute())
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			else
				return True;
			}
			*/
		}
		
		
		
		public function changePassword ( $data = [] )
		{
			if ( $data['txtPassword'] != $data['txtRePassword'] OR $data['txtPassword'] == $data['txtOldPassword'] )
			{
				echo "Wrong Input";
			}
			else
			{
				$query = "update registrant set password = ?, password_cr = ? where rgt_id = ".$_SESSION['user'][0]['id'];
				
				$stmt = $this->db -> stmt_init ();
				$stmt->prepare ( $query );
				$stmt->bind_param ( 'ss', $data['txtPassword'], md5 ( $data["txtPassword"] ) );
				if (!$stmt->execute())
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				else
					return True;
				
			}
			
		}
		
		
		
		public function registerUser ( $data = [] )
		{
			$mlist = ["cmbSalutation","txtFirstname","txtMiddleName","txtLastName","txtPhotoHonour","txtPhotoClub","txtAddrLine1","txtAddrLine2","txtAddrLine3","txtCity","txtState","txtZip","cmbCountry","salonType", "txtEmail","txtMobile","txtPassword"];
			
			$valid = new Validation ( $this->db );
			if (empty($data['txtFirstname']) OR empty($data['txtLastName']) OR empty($data['txtAddrLine1']) OR empty($data['txtCity']) OR empty($data['txtState']) OR empty($data['txtZip']))
			{
				$error[] = "Please check the required fields. <a href='signup.php'>Back</a>";
				echo "Please check the required fields. <a href='signup.php'>Back</a>";
				exit ();
			}
			else if ( empty ( $data['cmbCountry'] ) )
			{
				$error[] = "You must select a country! <a href='signup.php'>Back</a>";
				echo "You must select a country! <a href='signup.php'>Back</a>";
				exit ();
			}
			else if ( empty ( $data['salonType'] ) )
			{
				/*$error[] = "You must select a section! <a href='signup.php'>Back</a>";
				echo "You must select a section! <a href='signup.php'>Back</a>";
				exit ();*/
				$data['salonType'] = 2;
			}
			if ( $valid -> emailCheck ( $data["txtEmail"] ) != True )
			{
				$error[] = "Check Your Email !";
				echo 'Check Your Email ! <a href="signup.php">Back</a>';
				exit ();
			}
			else if ( $valid -> duplicateEmail ( $data['txtEmail'] ) > 0 )
			{
				$error[] = "Duplicate Email !";
				echo 'Duplicate Email ! <a href="signup.php">Back</a>';
				exit ();
			}
			else if ( empty( $data['txtPassword'] ) )
			{
				$error[] = "Password must be at least 5 characters! <a href='signup.php'>Back</a>";
				echo "Password must be at least 5 characters! <a href='signup.php'>Back</a>";
				exit ();
			}
			else if ( !$valid -> passwordLengthCheck ( $data['txtPassword'] ) )
			{
				$error[] = "Password must be at least 5 characters! <a href='signup.php'>Back</a>";
				echo "Password must be at least 5 characters! <a href='signup.php'>Back</a>";
				exit ();
			}
			
			else
			{
			
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			$id = NULL;
			$active = 1;
			
			$query = "insert into registrant values ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
			
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			$stmt->bind_param ( 
								'sisssssssssssssssssis', 
								$id, 
								$data["salonType"], 
								$data["txtEmail"], 
								$data["txtPassword"],
								md5 ( $data["txtPassword"] ),
								$data["cmbSalutation"], 
								strtoupper ( $data["txtFirstname"] ), 
								strtoupper ( $data["txtMiddleName"] ), 
								strtoupper ( $data["txtLastName"] ), 
								strtoupper ( implode ( ',', $data["txtPhotoHonour"] ) ),
								strtoupper ( $data["txtPhotoClub"] ),
								strtoupper ( $data["txtAddrLine1"] ),
								strtoupper ( $data["txtAddrLine2"] ),
								strtoupper ( $data["txtAddrLine3"] ),
								strtoupper ( $data["txtCity"] ),
								strtoupper ( $data["txtState"] ),
								$data["txtZip"],
								$data["cmbCountry"],
								$data["txtMobile"],
								$active,
								$dt 
							);
			if (!$stmt->execute())
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			 
			$lastId = $this->db -> insert_id;
			
			$mm = new User ( $this->db );
			$con = $mm->selectUserCountry ( $lastId );
			$country = $con[0]['country'];
			
			$name =  $data["cmbSalutation"].' '.$data["txtFirstname"].' '.$data["txtMiddleName"].' '.$data["txtLastName"];
			$user_dtl[] = array ( 'id'=>$lastId, 'email'=> $data["txtEmail"], 'password' => md5 ( $data["txtPassword"] ), 'name' => $name, 'salontype' => $data["salonType"], 'country' => $country );
			return $user_dtl;
			}
		}
		
		
		
		
		
		
		public function selectCountry ( $id = NULL )
		{
			if ( isset ( $id ) )
			{
				$id = intval ( $id );
				if ( $id > 0 )
				{
					$query = "select country_id, country from countries where country_id = '".$id."' order by country";
				}
				else
				{
					echo "Check Country Code";
					exit ();
				}
			}
			else
			{
				$query = "select country_id, country from countries order by country";
			}
			
			
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $country_id, $country );
				$contry_dtl = [];
				while ( $stmt -> fetch () )
				{
					$country_dtl[] = array ( 'id'=>$country_id, 'country_name' => $country );
				}
				$stmt -> close ();
				return $country_dtl;
			
		}
		
		public function userSelect ( $id = NULL )
		{
			
			$id = intval ( $id );
			
			$query = "select x.salontype_id, x.salutation, x.fname, x.mname, x.lname, x.eml_login, x.honour, x.club, x.addr1, x.addr2, x.addr3, x.city_town_vill, x.state_province, x.zipcode, x.country, x.mobile from registrant x where x.rgt_id = '".$id."'";
				
			
			try 
			{
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $salontype_id, $salutation, $fname, $mname, $lname, $eml_login, $honour, $club, $addr1, $addr2, $addr3, $city, $state, $zipcode, $country, $mobile );
				$user_dtl = [];
				while ( $stmt -> fetch () )
				{
					$user_dtl[] = array (
											'salontype' => $salontype_id,
											'salute' => $salutation,
											'fname' => $fname,
											'mname' => $mname,
											'lname' => $lname,
											'honour' => $honour,
											'club' => $club,
											'addr1' => $addr1,
											'addr2' => $addr2,
											'addr3' => $addr3,
											'city' => $city,
											'state' => $state,
											'zipcode' => $zipcode,
											'country' => $country,
											'email'=> $eml_login, 
											'mobile' => $mobile
										);
				}
				$stmt -> close ();
				return $user_dtl;
			} 
			catch ( Exception $e ) 
			{
				die($e->getMessage());
			}
		}
		
		
		public function insertPayDetails ( $id = NULL, $data = [] )
		{
			$id = intval ( $id );
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			
			$payid = NULL;
			
			$query = 'insert into payment_details values ( ?, ?, ?, ? )';
			
			try 
			{
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> bind_param ( 'siss', $payid, $id, $data['txtPay'], $dt );
				
				if (!$stmt->execute())
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				 
				return $this->db -> insert_id;
			}
			catch ( Exception $e )
			{
				die($e->getMessage());
			}
		}
		
		
		
		
		public function checkUserExists ( $data = [] )
		{
		/*
			$mlist = ["salutation" => "cmbSalutation",
						"fname" => "txtFirstname",
						"mname" => "txtMiddleName",
						"lname" => "txtLastName",
						"honour" => "txtPhotoHonour",
						"club" => "txtPhotoClub",
						"addr1" => "txtAddrLine1",
						"addr2" => "txtAddrLine2",
						"addr3" => "txtAddrLine3",
						"city_town_vill" => "txtCity",
						"state_province" => "txtState",
						"zipcode" => "txtZip",
						"country" => "cmbCountry",
						"salontype_id" => "salonType", 
						"eml_login" => "txtEmail",
						"mobile" => "txtMobile",
					];
			$data['txtFirstname'] = $valid -> inputCheck ( $data['txtFirstname'] );
			$data['txtLastName'] = $valid -> inputCheck ( $data['txtLastName'] );
			$data['txtAddrLine1'] = $valid -> inputCheck ( $data['txtAddrLine1'] );
			$data['txtCity'] = $valid -> inputCheck ( $data['txtCity'] );
			$data['txtState'] = $valid -> inputCheck ( $data['txtState'] );
			$data['txtZip'] = $valid -> inputCheck ( $data['txtZip'] );*/
			
			
			$query = "select x.salontype_id, x.salutation, x.fname, x.mname, x.lname, x.eml_login, x.honour, x.club, x.addr1, x.addr2, x.addr3, x.city_town_vill, x.state_province, x.zipcode, x.country, x.mobile from registrant x where x.fname = '".$data['txtFirstname']."' and x.lname = '".$data['txtLastName']."' and x.addr1 = '".$data['txtAddrLine1']."' and x.city_town_vill = '".$data['txtCity']."' and x.state_province = '".$data['txtState']."' and x.zipcode = '".$data['txtZip']."'";
			
			$result = $this->db->query ( $query );
			return $result -> num_rows;
		}
		
		
		
		
		
		
			/* 
			**************************************************
			Profile Image related methods 
			**************************************************
			*/
			
			
			public function insertUserWithProfileImage ( $id = 0, $profile = '' )
			{
				//$query = 'update registrant set profile = "'.$profile.'" where rgt_id = '.$id;
				$query = "insert into profiles values ( Null, ".$id.", '".$profile."' )";
				return $this->db->query ( $query );
			}
			
			public function updateUserWithProfileImage ( $id = 0, $profile = '' )
			{
				$query = 'update profiles set profilename = "'.$profile.'" where rgt_id = '.$id;
				return $this->db->query ( $query );
			}
			
			public function showUserProfileImage ( $id = 0 )
			{
				$query = 'select profilename from profiles where rgt_id = '.$id;
				$result = $this->db->query ( $query );
				
				while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
				{
					return $row['profilename'];
				}
			}
			
			public function userProfileImageExists ( $id = 0 )
			{
				$query = 'select * from profiles where rgt_id = '.$id;
				$result = $this->db->query ( $query );
				return $result -> num_rows;
			}
			
			
			
			public function checkProfileImage ( $data, $filesize = 0 )
			{
				$flag = 0;
				//$file_info = getimagesize ( $data["tmp_name"] );
				
				if ( exif_imagetype($data["tmp_name"]) != IMAGETYPE_JPEG )
				{
					$flag = 1;
				}
				
				if( $data["size"] > $filesize )
				{
						$flag = 2;
				}
				
				return $flag;
			}
			
			
			public function uploadProfileImage ( $data, $path='', $newFileName='' )
			{
				
				if ( move_uploaded_file($data["tmp_name"],$path.$newFileName ) )
				{
					return TRUE;
				}
				
				return FALSE;
			}
			
			
			public function deleteOldProfileImage ( $oldFileName='', $path='' )
			{
				if ( unlink ( $path.$oldFileName ) )
				{
					return TRUE;
				}
				return FALSE;
			}

		
		
	}
	
	
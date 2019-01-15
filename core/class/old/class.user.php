<?php

	class User extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		public function loginCheck ( $data = array () )
		{
			
				$email = ''; $password = '';
				$valid = new Validation ( $this->db );
				if ( $valid -> emailCheck ( $data['email'] ) )
				{
					$email = $data['email'];
					$password = $valid -> hashMyPassword ( $data['password'] );	
					
				
				
					/*$query = 'select rgt_id, salontype_id, eml_login, password_cr, concat( salutation, " ", fname, " ", mname, " ", lname ) as name from registrant where eml_login = "'.$email.'" and password_cr = "'.$password.'"';*/
					
					$query = 'select x.rgt_id, x.salontype_id, x.eml_login, x.password_cr, concat( x.salutation, " ", x.fname, " ", x.mname, " ", x.lname ) as name, y.country from registrant x, countries y where eml_login = "'.$email.'" and password_cr = "'.$password.'" and x.country = y.country_id';
					//echo $query;
					
					try 
					{
						$stmt = $this->db -> stmt_init ();
						$stmt -> prepare ( $query );
						$stmt -> execute ();
						$stmt -> bind_result ( $rgt_id, $salontype_id, $eml_login, $password_cr, $name, $country );
						$user_dtl = [];
						while ( $stmt -> fetch () )
						{
							$user_dtl[] = array ( 'id'=>$rgt_id, 'salontype' => $salontype_id, 'email'=> $eml_login, 'password' => $password_cr, 'name' => $name, 'country' => $country );
						}
						$stmt -> close ();
						
						return $user_dtl;
					}
					catch ( Exception $e ) 
					{
						die($e->getMessage());
					}
				}
				else
				{
					echo "Use proper Email";
				}
			
		}
		
		public function insertImageData ( $data = array() )
		{
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			$id = NULL;
			$query = "insert into images values ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			$stmt->bind_param ( 'siisssiis', $id, $data['theme_id'], $data['user_id'], $data['name'], $data['new_name'], $data['title'], $data['active'], $data['status'], $data['modified'] );
			
			if (!$stmt->execute())
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			 
			$lastId = $this->db -> insert_id;
			return $lastId;
		}
		
		
		
		public function number_pad($number,$n) {
			return str_pad( (int) $number,$n,"0",STR_PAD_LEFT );
		}
		
		public function newFileName ( $themeId )
		{
			$themeId = intval ( $themeId );
			$im = new Images ( $this->db );
			
			
			/*$lastNo = [];
			$lastNo = $im -> selectPerUser ( $themeId );
			foreach ( $lastNo as $last )
			{
				foreach ( $last as $ls )
				{
					$lsn = $ls;
				}
			}
			$lsn ++;*/
			
			$idn = $this -> number_pad ( $_SESSION['user'][0]['id'], 4 );
			
			//------------------
			
			$newNames = $im -> selectImageNewName ( $themeId );
			$themeNums = [];
			foreach ( $newNames as $nme )
			{
				foreach ( $nme as $nm )
				{
					$themeNums[] = substr ( $nm, -1 );
				}
			}
			$photoLimit = '';
			$themes = new Themes ( $this -> db );
			$thm = $themes -> themeLoad ( $themeId );
			foreach ( $thm as $tm )
			{
				$photoLimit = $tm['photo_max'];
			}
			
			for ( $i=1; $i <= $photoLimit; $i++ )
			{
				if ( in_array ( $i, $themeNums ) )
				{
				
				}
				else
				{
					return 'FIP'.date('Y').'-'.$idn.'-'.$themeId.'-'.$i;
					break;
				}
			}
			
			
		}
		
		public function selectUser ( $id = NULL )
		{
			if ( $id == NULL OR $id == 0 )
			{
				$query = "select x.salontype_id, concat ( x.salutation, ' ', x.fname, ' ', x.mname, ' ', x.lname ) as name, x.eml_login, x.honour, x.club, concat ( trim( x.addr1 ), '\n', trim( x.addr2 ), '\n', trim( x.addr3 ), '\n', trim( x.city_town_vill ), '\n', trim( x.state_province ), '\n', trim( x.zipcode ), '\n', trim( y.country )) as address, x.mobile from registrant x, countries y where x.country = y.country_id";
				
			}
			else
			{
				$id = intval ( $id );
				$query = "select x.salontype_id, concat ( x.salutation, ' ', x.fname, ' ', x.mname, ' ', x.lname ) as name, x.eml_login, x.honour, x.club, concat ( trim( x.addr1 ), '\n', trim( x.addr2 ), '\n', trim( x.addr3 ), '\n', trim( x.city_town_vill ), '\n', trim( x.state_province ), '\n', trim( x.zipcode ), '\n', trim( y.country )) as address, x.mobile from registrant x, countries y where x.rgt_id = '".$id."' and x.country = y.country_id";
			}
				
			
			try 
			{
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $salontype_id, $name, $eml_login, $honour, $club, $address, $mobile );
				$user_dtl = [];
				while ( $stmt -> fetch () )
				{
					$user_dtl[] = array ( 'salontype' => $salontype_id,
											'name' => $name,
											'honour' => $honour,
											'address' => $address,
											'email'=> $eml_login, 
											 'mobile' => $mobile,
											'club' => $club
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
		
		
		
		
		public function selectAdminUser ( $id = NULL )
		{
			if ( $id == NULL OR $id == 0 )
			{
				$query = "select x.rgt_id, x.salontype_id, concat ( x.salutation, ' ', x.fname, ' ', x.mname, ' ', x.lname ) as name, x.eml_login, x.honour, x.club, concat ( trim( x.addr1 ), '\n', trim( x.addr2 ), '\n', trim( x.addr3 ), '\n', trim( x.city_town_vill ), '\n', trim( x.state_province ), '\n', trim( x.zipcode ), '\n', trim( y.country )) as address, x.mobile from registrant x, countries y where x.country = y.country_id";
				
			}
			else
			{
				$id = intval ( $id );
				$query = "select x.salontype_id, concat ( x.salutation, ' ', x.fname, ' ', x.mname, ' ', x.lname ) as name, x.eml_login, x.honour, x.club, concat ( trim( x.addr1 ), '\n', trim( x.addr2 ), '\n', trim( x.addr3 ), '\n', trim( x.city_town_vill ), '\n', trim( x.state_province ), '\n', trim( x.zipcode ), '\n', trim( y.country )) as address, x.mobile from registrant x, countries y where x.rgt_id = '".$id."' and x.country = y.country_id";
			}
				
			
			try 
			{
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $rgt_id, $salontype_id, $name, $eml_login, $honour, $club, $address, $mobile );
				$user_dtl = [];
				while ( $stmt -> fetch () )
				{
					$user_dtl[] = array ( 'user_id' => $rgt_id,
											'salontype' => $salontype_id,
											'name' => $name,
											'honour' => $honour,
											'address' => $address,
											'email'=> $eml_login, 
											 'mobile' => $mobile,
											'club' => $club
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
		
		public function selectUserCountry ( $id = NULL )
		{
			$id = intval ( $id );
			
			$query = "select x.rgt_id, concat ( x.salutation, ' ', x.fname, ' ', x.mname, ' ', x.lname ) as name, x.eml_login, y.country, x.mobile from registrant x, countries y where x.rgt_id = '".$id."' and x.country = y.country_id";
			//echo $query;
			
			try 
			{
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $rgt_id, $name, $eml_login, $country, $mobile );
				$user_dtl = [];
				while ( $stmt -> fetch () )
				{
					$user_dtl[] = array ( 'user_id' => $rgt_id,
											'name' => $name,
											'email'=> $eml_login,
											'country' => $country,										
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
		
		
		public function selectSalonType ( $id = NULL )
		{
			$id = intval ( $id );
			$query = 'select x.salontype_id, y.name from registrant x, salontype y where x.rgt_id = '.$id.' and x.salontype_id = y.id';
			//echo $query;
			$result = $this->db->query ( $query );
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ))
			{
				return $row['name'];
			}
		}
		
		
	   public function updatedUserProfile($id = NULL)
        {
            $id = intval ( $id );
			
			$query = 'select x.rgt_id, x.salontype_id, x.eml_login, x.password_cr, concat( x.salutation, " ", x.fname, " ", x.mname, " ", x.lname ) as name, y.country from registrant x, countries y where x.rgt_id = '.$id.'  and x.country = y.country_id' ;
			       try
			        {
						$stmt = $this->db -> stmt_init ();
						$stmt -> prepare ( $query );
						$stmt -> execute ();
						$stmt -> bind_result ( $rgt_id, $salontype_id, $eml_login, $password_cr, $name, $country );
						$udata = [];
						while ( $stmt -> fetch () )
						{
							$udata[] = array ( 'id'=>$rgt_id, 'salontype' => $salontype_id, 'email'=> $eml_login, 'password' => $password_cr, 'name' => $name, 'country' => $country );
						}
						$stmt -> close ();
						return $udata;
					}
					catch ( Exception $e ) 
					{
						die($e->getMessage());
					}
			
        }		
		
	}
	
	
<?php

	class Sms extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		public function addPerson ( $data = [] )
		{
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			$id = NULL;
			
			$query = "insert into addressbook values ( ?, ?, ?, ? )";
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			$stmt->bind_param ( 'ssss', $id, $data['cname'], $data['cmobile'], $dt );
			
			if (!$stmt->execute())
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			 
			$lastId = $this->db -> insert_id;
			return $lastId;
		}
		
		
		public function updatePerson ( $id='', $data = [] )
		{
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			$id = intval($id);
			
			$query = 'update addressbook set name = "'.$data['cname'].'", mobileno = "'.$data['cmobile'].'", modified = "'.$dt.'" where id = '.$id;
			
			$stmt = $this->db -> stmt_init ();
			$stmt->prepare ( $query );
			
			
			if (!$stmt->execute())
			{
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				return 0;
			}
			else
			{
				return -1;
			}
		}
		
		
		public function selectPerson ( $id=NULL )
		{
			if ( !empty($id) )
			{
				$id = intval($id);
				$sql = 'select * from addressbook where id = "'.$id.'"';
			}
			else
			{
				$sql = "select * from addressbook";
			}
			$result = $this->db->query ( $sql );
			$list = [];
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[$row['id']] = array( $row['name'], $row['mobileno']);
			}
			return $list;
		}
		
		
		
		
		public function number_pad($number,$n) {
			return str_pad( (int) $number,$n,"0",STR_PAD_LEFT );
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
	
	
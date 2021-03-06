<?php

	class Admin extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		public function loginCheck ( $data = array () )
		{
			
				$admn = ''; $password = '';
				$valid = new Validation ( $this->db );
				if ( !empty($data['admin_id']) AND !empty($data['admin_pass']))
				{
					$admn = $valid -> inputCheck ( $data['admin_id'] );
					$passwrd = $valid -> hashMyPassword ( $data['admin_pass'] );
					return $this -> selectAdminUser ( $admn, $passwrd );
				}
				else
				{
					$msg = 'Something wrong';
					return $msg;
				}
			
		}
		
		public function selectAdminUser ( $admn=NULL, $passwrd = NULL )
		{
			$usrid = strval ( $admn );
			$query = 'select userid, user_pass from admindetails where userid = "'.$usrid.'" and user_pass = "'.$passwrd.'"';
			
			
			
			$result = $this->db->query($query);
			if ( $result->num_rows > 0 )
			{
				return true;
				
			}
			else
			{
				return false;
			}
			
		}
		
		public function getParticipants ( $id=NULL )
		{
			$user = new User ( $this->db );
			return $user->selectAdminUser( $id );
		}
		
		
		public function getPaymentDetails ( $id='' )
		{
			$id = intval ( $id );
			if ( $id != 0 ):
				$query = 'select * from payment_details where rgt_id = '.$id;
				$result = $this->db->query ( $query );
				if ( $result->num_rows > 0 ):
					$list = [];
					while ( $row = $result->fetch_array ( MYSQLI_ASSOC ))
					{
						$list[] = array('paydtl'=>$row['pay_detail']);
					}
				else :
					$list[] = array('paydtl'=>'NA');
				endif;
				return $list;
			endif;
		}
		
		
	}
	
	
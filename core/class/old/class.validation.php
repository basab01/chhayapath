<?php

	class Validation extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
	
		public function inputCheck ( $data = NULL )
		{
			$data = trim ( $data );
			$data = stripslashes ( $data );
			$data = htmlspecialchars ( $data );
			$data = mysqli_real_escape_string ( $this->db,$data );
			return $data;
		}
		
		public function emailCheck ( $email = NULL )
		{
			return filter_var( $email, FILTER_VALIDATE_EMAIL );
		}
		
		public function duplicateEmail ( $email=NULL )
		{
			$query = 'select * from registrant where eml_login = "'.$email.'"';
			$result = $this->db->query($query);
			return $result->num_rows;
		}
		
		public function fileNameCheck ( $data = NULL )
		{
			return preg_replace ( "/[^\w\.]/", '', $data );
		}
		
		public function hashMyPassword ( $data = NULL )
		{
			return md5 ( $data );
		}
		
		public function passwordLengthCheck ( $data = NULL )
		{
			if ( strlen ( $data ) < 5 OR strlen ( $data ) > 15 )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
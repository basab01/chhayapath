<?php

	class Result extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		public function selectColorPrintAward ( $id )
		{
			$query = "select * from all_award_color_print where circuit=$id order by display_order";
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'title'=>$row['title'],
								  'author'=>$row['author'],
								  'country'=>$row['country'],
								  'award'=>$row['award']
								);
			}
			
			return $list;
		}
		
		public function selectNaturePrintAward ( $id )
		{
			$query = "select * from all_award_nature_print where circuit=$id order by display_order";
			//echo $query;
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'title'=>$row['title'],
								  'author'=>$row['author'],
								  'country'=>$row['country'],
								  'award'=>$row['award']
								);
			}
			
			return $list;
		}
		
		
		public function selectDigitalAward ( $id, $theme_id )
		{
			/*
			SELECT * from award_det x inner join awardlist_master y on x.award_id=y.award_id WHERE x.theme_id = 5 and x.award_id <> 0
			*/
			/*$query = "select * from all_award_digital where circuit_id=$id and theme_id = $theme_id order by disp_ord";*/
			
			$query = "SELECT * from award_det x inner join awardlist_master y on x.award_id=y.award_id WHERE x.circuit_id = $id and x.theme_id = $theme_id and x.award_id <> 0 order by y.award_id";
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'title'=>$row['title'],
								  'author'=>$row['regname'],
								  'country'=>$row['country'],
								  'award'=>$row['award_name']
								);
			}
			
			return $list;
		}
		
		
		/*
		$query = "SELECT x.image_id_actual, x.section_id, sum(x.selection_marks) as total, y.image_id, y.grace_to, z.name, z.theme_id, z.user_id FROM `selection_marks_table` x left join grace_marks y on x.image_id_actual = y.image_id inner join images z on x.image_id_actual=z.id where x.section_id=$theme_id group by image_srl_no";
		*/
		
		
		public function getImagesSelected ( $circuit_id, $theme_id )
		{
			$query = "SELECT x.image_id_actual, x.section_id, sum(x.selection_marks) as total, z.name, z.theme_id, z.user_id FROM `selection_marks_table` x inner join images z on x.image_id_actual=z.id where x.section_id=$theme_id group by image_srl_no";
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC ))
			{
				if ( !empty ( $row['grace_to'] ) ) $total_marks = $row['grace_to'];
				else $total_marks = $row['total'];
				$list[] = array ( 'image_id'=>$row['image_id_actual'],
								  'image_name'=>$row['name'],
								  'theme_id'=>$row['theme_id'],
								  'user_id'=>$row['user_id'],
								  'total_marks'=>$total_marks
								);
			}
			
			return $list;
		}
		
		
		
		
		public function getImagesAccepted ( $imgs = '' )
		{
			$query = "SELECT x.id,x.theme_id,x.user_id,x.name,x.title, x.active, y.fname, y.mname, y.lname, z.country FROM `images` x inner join registrant y on x.user_id = y.rgt_id inner join country_master z on y.country=z.country_id where x.id in ( $imgs ) and y.active = 1 order by z.country,y.lname,y.fname,y.mname";
			//echo $query;
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'image_id'=>$row['id'],
								  'theme_id'=>$row['theme_id'],
								  'userid'=>$row['user_id'],
								  'name'=>$row['name'],
								  'title'=>$row['title'],
								  'fname'=>$row['fname'],
								  'mname'=>$row['mname'],
								  'lname'=>$row['lname'],
								  'country'=>$row['country']
								);
			}
			
			return $list;
		}
		
		
		public function dumpImagesAccepted ( $imgs = '' )
		{
			$query = "create table u1(SELECT x.id,x.theme_id,x.user_id,x.name,x.title, x.active, y.fname, y.mname, y.lname, z.country FROM `images` x inner join registrant y on x.user_id = y.rgt_id inner join country_master z on y.country=z.country_id where x.id in ( $imgs ) and y.active = 1 order by z.country,y.lname,y.fname,y.mname)";
			
			$result = $this->db->query($query);
			
			
			return 0;
		}
		
		
		public function imageAcceptedNew( $id = '' )
		{
			$query = 'select * from marks_all_new where section_id = '.$id;
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'image_id'=>$row['image_id'],
								  'theme_id'=>$row['section_id'],
								  'userid'=>$row['rgt_id'],
								  'filename'=>$row['file_name'],
								  'title'=>$row['Title'],
								  'name'=>$row['Name2'],
								  'country'=>$row['country'],
								  'awardname'=>$row['award_name']
								);
			}
			return $list;
		}
		
		
		
		public function imageAwardNew( $id = '' )
		{
			$query = 'select * from marks_all_new where section_id = '.$id.' and award_name != ""';
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array ( 'image_id'=>$row['image_id'],
								  'theme_id'=>$row['section_id'],
								  'userid'=>$row['rgt_id'],
								  'filename'=>$row['file_name'],
								  'title'=>$row['Title'],
								  'name'=>$row['Name2'],
								  'country'=>$row['country'],
								  'awardname'=>$row['award_name']
								);
			}
			return $list;
		}

		 
		
		
		public function selectAcceptedNaturePrint ( $userid )
		{
			if ( !empty ( $userid ) )
			{
				$query = 'select * from all_accept_nature_print where rgt_id = '.$userid.' order by country,author';
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					//if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					//{
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					//}
				}
			}
			else
			{
				$query = 'select * from all_accept_nature_print order by country,author';
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					{
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					}
				}
			}
			
			return $list;
		}
		
		public function selectAcceptedColourPrint ( $userid )
		{
			if ( !empty($userid))
			{
				$query = 'select * from all_accept_color_print where rgt_id='.$userid.' order by country,author';
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					//if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					//{
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					//}
				}
			}
			else
			{
				$query = 'select * from all_accept_color_print order by country,author';
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					{
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					}
				}
			}
			
			return $list;
		}
		
		
		
		public function selectAcceptedDigital ( $userid, $theme_id )
		{
			if(!empty($userid))
			{
				$query = 'select * from all_accept_digital where theme_id = '.$theme_id.' and rgt_id = '.$userid.' order by country,author';
				
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					/*if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					{*/
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					//}
				}
			}
			else
			{
				$query = 'select * from all_accept_digital where theme_id = '.$theme_id.' order by country,author';
				
				$result = $this->db->query($query);
				$list = [];
				
				while ( $row = $result->fetch_array(MYSQLI_ASSOC))
				{
					if ( $row['accept1'] == 'A' OR $row['accept2'] == 'A' OR $row['accept3'] == 'A' )
					{
						$list[] = array ( 'title'=>$row['title'],
										  'author'=>$row['author'],
										  'country'=>$row['country'],
										  'accept1'=>$row['accept1'],
										  'accept2'=>$row['accept2'],
										  'accept3'=>$row['accept3']
										);
					}
				}
			}
			//echo $query;
			
			
			return $list;
		}
		
		
		/*
		
			This method is created for "Chhayapath Digital Salon"
		*/
		
		
		public function selectAcceptedByTheme ( $themeid = '' )
		{
			$query = 'select * from image_new where theme_id='.$themeid.' and active=1 and accepted like "A"';
			$result = $this->db->query($query);
			$list=[];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array (
									'country'=>$row['country'],
									'author'=>$row['author1'],
									'imageTitle'=>$row['title'],
									'payment_status'=>$row['pmnt_stat']
								);
			}
			
			return $list;
		
		}
		
		
		
		public function selectAwardByTheme ( $themeid = '' )
		{
			$query = 'select * from image_new where theme_id='.$themeid.' and active=1 and award_id > 0 order by award_id';
			$result = $this->db->query($query);
			$list=[];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[] = array (
									'country'=>$row['country'],
									'author'=>$row['author1'],
									'imageTitle'=>$row['title'],
									'award_id'=>$row['award_id'],
									'award_name'=>$row['award'],
									'payment_status'=>$row['pmnt_stat']
									
								);
			}
			
			return $list;
		
		}
		
	}
	
	
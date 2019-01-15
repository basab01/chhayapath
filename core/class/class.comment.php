<?php

	class Comment extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		
		
		public function selectComments ( $userid = NULL )
		{
			if ( isset ( $userid ))
			{
				$userid = intval ( $userid );
				$query = "select id, reg_id, comment from comments where reg_id = '".$userid."'";
			}
			else
			{
				$query = "select id, reg_id, comment from comments";
			}
			
			$result = $this->db->query($query);
			$list = [];
			while ( $row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$list[$row['reg_id']][] = array ( 'id'=>$row['id'],'comment'=>$row['comment']);
			}

			return $list;
		}
		
		public function insertComment ( $userid = NULL, $data = [] )
		{
			if ( isset ( $userid ))
			{
				$userid = intval( $userid );
				
				$date = new Datetime ( 'Asia/Kolkata' );
				$dt = $date->format('Y-m-d H:i:s');
				
				
				$query = 'insert into comments values ( NULL, '.$userid.',"'.$data['comment'].'","'.$dt.'")';
				try
				{
					$result = $this->db->query($query);
					
					$lastId = $this->db -> insert_id;
					return $lastId;
				}
				catch ( Exception $e )
				{
					die($e->getMessage());
				}
				
			}
		}
		
		
		public function getComments ( $id )
		{
			$query = 'select c.id,c.reg_id,c.comment,r.rgt_id,r.eml_login, r.salutation, 
			r.fname, coalesce(r.mname, "") as mname, r.lname from comments c, registrant r where c.id = '.$id.' and c.reg_id = r.rgt_id';
			
			try {
				$result = $this->db->query($query);
				$list = [];
				while ( $row = $result->fetch_array( MYSQLI_ASSOC ))
				{
					$name = ''; $name = $row['salutation'].' '.$row['fname'].' '.$row['mname'].' '.$row['lname'];
					$list[] = array ( 'user_id' => $row['reg_id'], 'comment'=> $row['comment'],
					'email' => $row['eml_login'], 'name'=>"$name" );
				}
				return $list;
			}
			catch ( Exception $e )
			{
				die($e->getMessage());
			}
		}
		
		
	}
	
	
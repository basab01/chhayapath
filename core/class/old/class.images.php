<?php

	class Images extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		/*private function __inputCheck ( $data = NULL )
		{
			$data = trim ( $data );
			$data = stripslashes ( $data );
			$data = htmlspecialchars ( $data );
			$data = mysql_real_escape_string ( $this->db, $data );
			return $data;
		}
		
		private function __emailCheck ( $email = NULL )
		{
			return filter_var( $email, FILTER_VALIDATE_EMAIL );
		}
		
		private function __fileNameCheck ( $data )
		{
			return preg_replace ( "/[^\w\.]/", '', $data );
		}
		*/
		
		
		public function insertData ( $data = array() )
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
			$stmt->close();
			return $lastId;
		}
		
		public function selectPerUser ( $themeid = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$themeid = intval ( $themeid );
			$imgs = [];
			if ( !empty ( $themeid ) )
			{
				$query = 'select id from images where theme_id = "'.$themeid.'" and user_id = "'.$idn.'" and active = 1';
				
				$stmt = $this->db -> stmt_init ();
				if ( $stmt -> prepare ( $query ) )
				{
					$stmt->execute();
					$stmt->store_result();
					$num = $stmt->num_rows;
					$stmt->close();
					if ( empty( $num ) ) $num = 0;
					$imgs[] = array ( 'imgnum' => $num );
					return $imgs;
				}
			}
		}
		
		
		public function checkImage ( $id = NULL )
		{
			$idn = intval ( $id );
			$imgs = [];
			
				$query = 'select id from images where user_id = "'.$idn.'" and active = 1';
				
				$stmt = $this->db -> stmt_init ();
				if ( $stmt -> prepare ( $query ) )
				{
					$stmt->execute();
					$stmt->store_result();
					$num = $stmt->num_rows;
					$stmt->close();
					
					return $num;
				}
			
		}
		
		public function selectImages ( $themeid = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$valid = new Validation ( $this->db );
			$themeid = $valid->inputCheck ( $themeid );
			
			$imgs = [];
			if ( !empty ( $themeid ) )
			{
				$query = 'select id, name, title from images where theme_id = "'.$themeid.'" and user_id = "'.$idn.'" and active = 1';
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $id, $name, $title );
				
				while ( $stmt -> fetch () )
				{
					$imgs[] = array ( 'id' => $id, 'name' => $name, 'title' => $title );
				}
				$stmt -> close ();
				return $imgs;
			}
		}
		
		public function updateImgTitle ( $imgid = NULL, $getInput = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$valid = new Validation ( $this->db );
			
			$getImgId = $valid -> inputCheck ( $imgid );
			$getTitle = $valid -> inputCheck ( $getInput );
			
			$query = 'update images set title = "'.$getTitle.'" where id = "'.$getImgId.'"';
			
			$result = $this->db->query ( $query );
			return $result;
		}
		
		public function imageDelete ( $imgid = NULL, $themeid = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$getImgId = intval ( $imgid );
			
			$query = 'delete from images where id = "'.$getImgId.'" and theme_id = "'.$themeid.'"';
			
			$result = $this->db->query ( $query );
			//$_SESSION['deleted']
			return $result;
		}
		
		public function selectImage ( $imgid = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$getImgId = intval ( $imgid );
			
			$query = 'select name from images where id = "'.$imgid.'"';
			
			$stmt = $this->db -> stmt_init ();
			$stmt -> prepare ( $query );
			$stmt -> execute ();
			$stmt -> bind_result ( $name );
			while ( $stmt -> fetch () )
			{
				$imgs[] = array ( 'name' => $name );
			}
			$stmt -> close ();
			return $imgs;
		}
		
		public function selectImageNewName ( $themeid = NULL )
		{
			$idn = $_SESSION['user'][0]['id'];
			$themeid = intval ( $themeid );
			$imgs = [];
			
			$query = 'select new_name from images where theme_id = "'.$themeid.'" and user_id = "'.$idn.'"';
			//echo $query;
			
			$stmt = $this->db -> stmt_init ();
			$stmt -> prepare ( $query );
			$stmt -> execute ();
			$stmt -> bind_result ( $name );
			while ( $stmt -> fetch () )
			{
				$imgs[] = array ( 'newName' => $name );
			}
			$stmt -> close ();
			return $imgs;
		}
		
		
		public function number_pad($number,$n) {
			return str_pad( (int) $number,$n,"0",STR_PAD_LEFT );
		}
		
		public function nwFileName ( $themeId, $type=NULL )
		{
			$themeId = intval ( $themeId );			
			$idn = $this -> number_pad ( $_SESSION['user'][0]['id'], 4 );
			
			//------------------
			
			$newNames = $this -> selectImageNewName ( $themeId );
			
			
			$themeNums = [];
			if ( !empty ( $newNames ) )
			{
				foreach ( $newNames as $nme )
				{
					foreach ( $nme as $nm )
					{
						$themeNums[] = substr ( $nm, -1 );
					}
				}
				
				$photoLimit = '';
				$themes = new Themes ( $this -> db );
				$type = intval ( $type );
				
				$thm = $themes -> themeLoad ( $themeId, $type );
				
				foreach ( $thm as $tm )
				{
					$photoLimit = $tm['photo_max'];
				}
				
				for ( $i=1; $i <= $photoLimit; $i++ )
				{
					if ( in_array ( $i, $themeNums ) )
					{
						//continue;
					}
					else
					{
						return 'FIP'.date('Y').'-'.$idn.'-'.$themeId.'-'.$i;
						break;
					}
				}
			}
			else
			{
				return 'FIP'.date('Y').'-'.$idn.'-'.$themeId.'-'.'1';
			}
			
		}
		
		
		public function selectBarcodeImages ( )
		{
			$idn = $_SESSION['user'][0]['id'];
			
			$imgs = [];
			if ( !empty ( $idn ) )
			{
				$query = 'SELECT images.name,
							images.new_name,
								images.title,
								themes.name from images,themes where 
							themes.id=images.theme_id and images.user_id = "'.$idn.'" and themes.salon_type="print" order by images.theme_id';
				$stmt = $this->db -> stmt_init ();
				$stmt -> prepare ( $query );
				$stmt -> execute ();
				$stmt -> bind_result ( $name, $new_name, $title, $themeName );
				
				while ( $stmt -> fetch () )
				{
					$imgs[] = array ( 'name' => $name, 'theme_name' => $themeName, 'title' => $title, 'new_name' => $new_name );
				}
				$stmt -> close ();
				return $imgs;
			}
		}
		
		public function selectGroupImages ( $id=NULL )
		{
			$id = intval ( $id );
			
			$query = 'select salon_type, theme_id, themes.name as themes, 
			group_concat(images.title order by images.new_name) as title, 
			group_concat(images.name order by images.new_name)as imgname 
			from images, themes 
			where user_id='.$id.' and 
			images.active=1 and 
			images.theme_id=themes.id 
			group by theme_id order by images.new_name';
	
			$result = $this->db->query ( $query );
			$list = [];
			
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[] = array(
								'salon_type' => $row['salon_type'], 
								'themes' => $row['themes'],
								'title' => $row['title'],
								'image_name'=>$row['imgname'],
								'theme_id' => $row['theme_id']
							);
			}
			return $list;
		}
		
		public function duplicateImgName ( $userid = Null, $filename = NULL )
		{
			$filename = strval ( $filename );
			$query = 'select title from images where name = "'.$filename.'" and user_id = '.$userid;
			$result = $this->db->query ( $query );
			
			return $result -> num_rows;
			
		}
		
		public function setImgActive ( $userid = NULL, $lastid = NULL )
		{
			$lastid = intval ( $lastid );
			$query = 'update images set active = 1 where id = '.$lastid.' and user_id = '.$userid;
			$result = $this->db->query($query);
			return $result;
		}
		
		public function checkDuplicateTitle ( $userid = NULL, $themeid = NULL, $title = NULL )
		{
			$themeid = intval ( $themeid );
			$query = 'select id from images where title like "'.$title.'" and theme_id = '.$themeid.' and user_id = '.$userid;
			$result = $this->db->query ( $query );
			return $result->num_rows;
		}
		
	}
	
		
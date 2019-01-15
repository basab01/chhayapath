<?php

	class Themes extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		public function saltype ( $id = NULL )
		{
			if ( isset ( $id ) )
			{
				$id = intval ( $id );
			}
			$mm = [ '1'=>'print', '2'=>'digital' ];
			if ( array_key_exists ( $id, $mm ) )
			return $mm[$id];
		}
		
		public function getThemes ()
		{
			$query = "select id, name, photolimit from themes where active = 1";
			$stmt = $this->db -> stmt_init ();
			$stmt -> prepare ( $query );
			$stmt -> execute ();
			$stmt -> bind_result ( $id, $name, $photolimit );
			$theme_dtl = [];
			while ( $stmt -> fetch () )
			{
				$theme_dtl[] = array ( 'id'=>$id, 'themeName' => $name, 'photo_max' => $photolimit );
			}
			$stmt -> close ();
			return $theme_dtl;
		}
		
		public function themeLoad ( $id = NULL, $type=NULL )
		{
			//if ( isset ( $_SESSION['user'] ) ) 
			$stype = $this->saltype ( $type );
			
			if ( !isset ( $id ) )
			{
				$query = "select id, name, photolimit from themes where active = 1 and salon_type = '".$stype."'";
			}
			else
			{
				$id = intval ( $id );
				$query = "select id, name, photolimit from themes
							where id = '".$id."' and active = 1 and salon_type = '".$stype."'";
			}
			
			$stmt = $this->db -> stmt_init ();
			$stmt -> prepare ( $query );
			$stmt -> execute ();
			$stmt -> bind_result ( $id, $name, $photolimit );
			$theme_dtl = [];
			while ( $stmt -> fetch () )
			{
				$theme_dtl[] = array ( 'id'=>$id, 'themeName' => $name, 'photo_max' => $photolimit );
			}
			$stmt -> close ();
			return $theme_dtl;
		}
		
		public function selectSalonType ( $id = NULL )/* table salontype */
		{
			if ( isset ( $id ) )
			{
				$id = intval ( $id );
				$query = "select id, name from salontype where id = '".$id."'";
			}
			else
			{
				$query = "select id, name from salontype";
			}
			
			$stmt = $this->db -> stmt_init ();
			$stmt -> prepare ( $query );
			$stmt -> execute ();
			$stmt -> bind_result ( $id, $name );
			$stype = [];
			while ( $stmt -> fetch () )
			{
				$stype[] = array ( 'id' => $id, 'name' => $name );
			}
			$stmt -> close ();
			return $stype;
		}
		
		public function getSalonType ( $name = NULL )
		{
			$name = strval ( $name );
			$sql = 'select salon_type from themes where name = "'.$name.'"';
			$result = $this->db->query ( $sql );
			$list = [];
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[] = $row['salon_type'];
			}
			return $list;
		}
		
		public function getTotalThemes ()
		{
			$query = 'select count(name) as total_themes from themes';
			$result = $this->db->query($query);
			
			while ( $row = $result->fetch_array ( MYSQLI_ASSOC ))
			{
				return $row['total_themes'];
			}
		}
		
		
	}
	
	
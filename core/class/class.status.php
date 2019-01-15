<?php

	class Status extends DB_connect {
		
		public function __construct ( $dbo = NULL )
		{
			parent::__construct( $dbo );
		}
		
		public function makeMyString ( $str = '' )
		{
			return preg_replace ( '/\s+/','_',$str );
		}
		
		public function getThemeNames ()
		{
			$th = new Themes ( $this->db );
			$themes = $th -> getThemes ();
			$mythemes = [];
			foreach ( $themes as $tt )
			{
				$str = '';
				$str = strtolower ( $tt['themeName'] );
				$str = $this -> makeMyString ( $str );
				$mythemes [] = $str;
			}
			return $mythemes;
		}
		
		public function createStatusTable ()
		{
			if ( isset ( $_SESSION['user'] ) )
			{
				$themes = '';
				$str = '';
				$themes = $this -> getThemeNames ();
				foreach ( $themes as $tt )
				{
					$str .= "{$tt} INT NOT NULL,\n";
				}
				
				$sql = "CREATE TABLE if not exists status (
						id INT AUTO_INCREMENT PRIMARY KEY,
						reg_id INT NOT NULL,
						confirm_print INT NOT NULL,
						confirm_digital INT NOT NULL,".$str."
						
						payment_print INT NOT NULL,
						payment_digital INT NOT NULL,
						active INT NOT NULL,
						modified DATETIME
						);";
				//echo $sql;
				return $this->db->query( $sql );
			}
		}
		
		public function selectStatusFields ()
		{
			$sql = "select * from status limit 1";
			$mfields = [];
			
			
			$result = $this->db->query( $sql );
			
			$finfo = $result -> fetch_fields ();
			foreach ( $finfo as $val )
			{
				$mfields[] = $val->name;
			}
				
			return $mfields;
		}
		
		public function selectImageStatus ( $id = NULL )
		{
			if ( isset ( $id ) )
			{
				$id = intval ( $id );
				$query = 'SELECT 
							images.user_id, 
							images.theme_id, 
							sum(images.active) as total_image, 
							themes.name FROM images, themes WHERE images.active = 1 and 
							themes.id = images.theme_id and images.user_id = '.$id.'
							group by images.theme_id';
			}
			else
			{
				$query = 'SELECT 
							images.user_id, 
							images.theme_id, 
							sum(images.active) as total_image, 
							themes.name FROM images, themes WHERE images.active = 1 and
							themes.id = images.theme_id 
							group by images.user_id,images.theme_id';
			}
				
						
			$result = $this->db->query ( $query );
			$list = [];
			while ( $row = $result -> fetch_array(  MYSQLI_ASSOC ) )
			{
				$theme_name = $this -> makeMyString ( $row['name']);
				$list[''.$row['user_id'].''][] = array ( 'user_id'=>$row['user_id'],'theme_id'=>$row['theme_id'],'name'=>$row['name'],'total_image'=>$row['total_image'] );
			}
			return $list;
		}
		
		public function selectPaymentStatus ( $iid = NULL )
		{
			if ( isset ( $iid ) )
			{
				$query = 'select * from payment_stat where reg_id = '.$iid;
			}
			else
			{
				$query = 'select * from payment_stat';
			}
			$result = $this->db->query ( $query );
			$list = [];
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[''.$row['reg_id'].''][] = array (
									'user_id' => $row['reg_id'],
									'confirm_print' => $row['confirm_print'],
									'confirm_digital'=>$row['confirm_digital'],
									'payment_print' => $row['payment_print'],
									'payment_digital' => $row['payment_digital'],
									'payment_due' => $row['payment_due'],
									'alt_value' => $row['alt_val'],
									'payment_received' => $row['payment_received'],
									'active'=>$row['active'],
									'currency'=>$row['cur_id']
								);
			}
			return $list;
		}
		
		public function checkUser ( $id = NULL )
		{
			$id = intval ( $id );
			$sql = 'select * from payment_stat where reg_id = "'.$id.'" limit 1';
			$result = $this->db->query($sql);
			
			return $result -> num_rows;
			
		}
		
		public function confirmSubmit ( $id = NULL, $type = NULL, $pay = [] )
		{
			$id = intval ( $id );
			$date = new Datetime ( 'Asia/Kolkata' );
			$dt = $date->format('Y-m-d H:i:s');
			if ( !empty( $pay ) )
			{
				$payval = $pay['total']; $cur_id = $pay['currency'];
				if ($payval == 40)
                     $altval = 31;
                else if ($payval == 30)	
                     $altval = 23;
                else if ($payval == 20)
                     $altval = 15;		
                else
                     $altval = $payval;				
			}
			
			$flag = $this -> checkUser ( $id );
			if ( $flag == 0 && preg_match ( "/digital|print/", $type ) )
			{
				if ( $type == 'digital' )
					$sql = 'insert into payment_stat values ( Null, '.$id.', 0, 0, 1, 0, 0, '.$payval.', '.$altval.', 0, '.$cur_id.', 1, "'.$dt.'" )';
				else if ( $type == 'print' )
					$sql = 'insert into payment_stat values ( Null, '.$id.', 1, 0, 0, 0, 0, '.$payval.', '.$altval.', 0,'.$cur_id.', 1, "'.$dt.'" )';
			}
			else if ( $flag > 0 && preg_match ( "/digital|print/", $type ) )
			{
				if ( $type == 'digital' )
					$sql = 'update payment_stat set confirm_digital = 1, payment_due = "'.$payval.'", alt_val="'.$altval.'", cur_id="'.$cur_id.'", modified = "'.$dt.'" where reg_id = '.$id;
				else if ( $type == 'print' )
					$sql = 'update payment_stat set confirm_print = 1, payment_due = "'.$payval.'", alt_val="'.$altval.'", cur_id="'.$cur_id.'", modified = "'.$dt.'" where reg_id = '.$id;
			}
			
				$result = $this->db->query ( $sql );
				return $result;
		}
		
		
		public function checkConfirmation ( $id = NULL, $type = NULL )
		{
			$id = intval ( $id );
			$type = strval ( $type );
			$flag = false;
			
			$sql = 'select confirm_print, confirm_digital from payment_stat where reg_id = "'.$id.'"';
			$result = $this->db->query ( $sql );
			
			while ( $row = $result -> fetch_array(  MYSQLI_ASSOC ) )
			{
				if ( $type == 'print' && $row['confirm_print'] > 0 ) $flag = True;
				else if ( $type == 'digital' && $row['confirm_digital'] > 0 ) $flag = True;
				else if ( $row['confirm_print'] > 0 && $row['confirm_digital'] > 0 ) $flag = True;
				else
					$flag = false;
			}
			return $flag;
		}
		
		public function checkPrintReceived ( $id = NULL )
		{
			$id = intval ( $id );
			
			
			$sql = 'select print_received from payment_stat where reg_id = "'.$id.'"';
			$result = $this->db->query ( $sql );
			
			if ( $result -> num_rows > 0 )
			{
			
				while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
				{
					return $row['print_received'];
				}
			}
			else
			{
				return -1;
			}
		}
		
		
		public function selectSalonType ( $type = NULL )
		{
			if ( isset ( $type ) )
			{	
				$type = strval ( $type );
				$sql = 'select name, min_val1, max_val1, min_val2, max_val2, unit_val1, unit_val2 from salontype where name = "'.$type.'"';
			}
			else
			{
				$sql = 'select name, min_val1, max_val1, min_val2, max_val2, unit_val1, unit_val2 from salontype';
			}
			$result = $this->db->query ( $sql );
			
			$list = [];
			
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[] = [ 'name' => $row['name'],
							'dollar_min' => $row['min_val1'],
							'dollar_max' => $row['max_val1'],
							'rupee_min' => $row['min_val2'],
							'rupee_max' => $row['max_val2'],
							'dollar_section_price' => $row['unit_val1'],
							'rupee_section_price' => $row['unit_val2']
							];
			}
			return $list;
		}
		
		public function displayStatus ( $id = NULL )
		{
			//$ss = new Status ( $this->db );
			if ( isset ( $id ) ) 
			{
				$id = intval ( $id );
				$thh = $this -> selectImageStatus ( $id );
			}
			else
			{
				$thh = $this -> selectImageStatus ();
			}
			
			$hold = ''; $other = []; $another = []; $guser = []; $themeList = []; $hh = ''; $themeNames = []; $stat = [];
			
			$thm = new Themes ( $this->db );
			$themes = $thm -> getThemes ();
			
			foreach ( $themes as $tt )
			{
				$themeList[ $tt['id'] ] = $tt['themeName'];
			}
			
			$themeNames = array_values ( $themeList );
			
			foreach ( $thh as $key => $val )
			{
				if ( $hold != $key )
				{
					$hold = $key;
					$guser[] = $key;
				
					foreach ( $val as $kk )
					{
						foreach ( $kk as $k => $v )
						{
							if ( $k == 'name' )
							{
								$str = $this -> makeMyString ( $v );
							}
							else if ( $k == 'total_image' )
							{
								$other[$key][$str][] = $v;
							}
						}
					}
				}
			}
			
			foreach ( $guser as $gg )
			{
				foreach ( $themeNames as $vl )
				{
					$str = $this -> makeMyString ( $vl );
					foreach ( $other[$gg] as $k=>$v )
					{
						if ( $str == $k ) $another[$gg][$vl] = $v[0];
					}
					
				}
			}
			
			$stat['themes'] = $themeNames;
			$stat [ 'users' ] = $guser;
			$stat [ 'lists' ] = $another;
			return $stat;
			
		}
		
		public function displayList ( $id = NULL )
		{
			$id = intval ( $id );
			
			$query = "select  images.user_id,
						count(distinct images.theme_id) as themes,
						count(distinct salon_type) as sections,
						sum(val1) as dollarval, 
						sum(val2) as rupeeval 
						from images,themes,charges 
						where images.theme_id = charges.id 
						and images.theme_id = themes.id 
						and  images.user_id = ".$id;
						
			$result = $this->db->query ( $query );
			$list = [];
			while ( $row = $result -> fetch_array( MYSQLI_ASSOC ) )
			{
				$list[] = array ( 'total_themes' => $row['themes'], 'total_sections' => $row['sections'], 'dollarval' => $row['dollarval'], 'rupeeval'=>$row['rupeeval'] );
			}
			
			$list = $list[0];
			return $list;
		}
		
		public function displayPaymentStat ( $data=[] )
		{
			$list = $data;
			$total = 0;
			
			$pp = $this -> selectSalonType ();
			
			if ( $_SESSION['user'][0]['country'] == 'India' )
			{
				if ( $list['rupeeval'] > $pp[2]['rupee_max'] )
					$total = $pp[2]['rupee_max'];
				else if ( $list['rupeeval'] < $pp[2]['rupee_min'] )
					$total = $pp[2]['rupee_min'];
				else
					$total = $list['rupeeval'];
			}
			else
			{
				if ( $list['dollarval'] > $pp[2]['dollar_max'] )
					$total = $pp[2]['dollar_max'];
				else
					$total = $list['dollarval'];
			}
			
			
			
			return $total;
		}
		
		
		
		
		
		
		public function displayPaymentStatus ( $id = NULL )
		{
			$th = $this -> selectImageStatus ( $_SESSION['user'][0]['id']);
			//print_r($th);
			$pp = $this -> selectSalonType ();
			$mm = new Themes ( $this->db );
			$salon_type = $mm->getSalonType ( 'Colour Print' );
			
			$total = 0;
			if ( $_SESSION['user'][0]['country'] == 'India' )
			{
				$dig_min_val = $pp[0]['rupee_min'];
				$dig_max_val = $pp[0]['rupee_max'];
				$dig_section = $pp[0]['rupee_section_price'];
			}
			else
			{
				$dig_min_val = $pp[0]['dollar_min'];
				$dig_max_val = $pp[0]['dollar_max'];
				$dig_section = $pp[0]['dollar_section_price'];
			}
			
			$print_sec = [1,2];
			$digital_sec = [3,4,5,6];
			$lst = [];
			
			
			
			foreach ( $th as $key => $val )
			{
				foreach ( $val as $vv )
				{
					foreach ( $vv as $k=>$v )
					{
					if ( $k == 'theme_id' && in_array( $v, $print_sec ) )
						$lst[$key]['print'][] = $v;
					if ( $k == 'theme_id' && in_array( $v, $digital_sec ) )
						$lst[$key]['digital'][] = $v;
					}
				}
			}
			
			
			$price = 0;
			
		
			if ( count ( $lst ) > 0 )
			{
				
					$no = count ( $lst[$_SESSION['user'][0]['id']]['digital'] );
					if ( $no == 1 ) $price = $dig_min_val;
					else
					{
						if ( $no < count ( $digital_sec ) )
							$price = $dig_min_val + ($no-1) * $dig_section;
						else
							$price = $dig_max_val;
					}
				
			}
			return $price;	
		}
		
		public function getConversion ( $total = Null )
		{
			$total = intval ( $total );
			if ( $total > 0 )
			{
				$query = 'select euroval from conversion where dollarval = '.$total;
				$result = $this->db->query ( $query );
				while ( $row = $result -> fetch_array( MYSQLI_ASSOC ) )
				{
					$list[] = [ $row['euroval'] ];
				}
				return $list[0][0];;
			}
		}
		
		
		public function updateLockStatus ( $userid = Null, $data = [] )
		{
			if ( isset ( $userid ) AND !empty ( $data ) )
			{
				$userid = intval ( $userid );
				( $data['salonType'] == 'Y' ) ? $data['salonType'] = 1 : $data['salonType'] = 0;
				$query = 'update payment_stat set confirm_print = "'.$data['salonType'].'", confirm_digital = "'.$data['salonType'].'" where reg_id = '.$data['userid'];
				$result = $this->db->query ( $query );
				return $result;
			}
			else
			{
				echo 'Something wrong!!';
			}
		}


		public function updatePaymentStatus ( $userid = Null, $data = [] )
		{
			if ( isset ( $userid ) AND !empty ( $data ) )
			{
				$userid = intval ( $userid );
				( $data['salonType'] == 'Y' ) ? $data['salonType'] = 1 : $data['salonType'] = 0;
				$query = 'update payment_stat set payment_print = "'.$data['salonType'].'", payment_digital="'.$data['salonType'].'", ';
				
				if ( $data['usertype'] == 3 AND $data['salonType'] == 1) $query .= 'payment_received = payment_due ';
				else if ( $data['usertype'] == 3 AND $data['salonType'] == 0 ) $query .= 'payment_received = 0 ';
				else if ( $data['usertype'] == 1 AND $data['salonType'] == 0 ) $query .= 'payment_received = 0 ';
				else if ( $data['usertype'] == 2 AND $data['salonType'] == 0 ) $query .= 'payment_received = 0 ';
				else if ( $data['usertype'] == 1 AND $data['salonType'] == 1 ) $query .= 'payment_received = payment_due ';
				else if ( $data['usertype'] == 2 AND $data['salonType'] == 1 ) $query .= 'payment_received = payment_due ';
				$query .= ' where reg_id = '.$data['userid'];
				
				$result = $this->db->query ( $query );
				return $result;
			}
			else
			{
				echo 'Something wrong!!';
			}
		}
		
		
		public function getPstat ()
		{
			return $this -> selectImageStatus ( $_SESSION['user'][0]['id']);
			
		}
		
		public function selectStype ()
		{
			$query = "select * from salontype";
			$result = $this->db->query ( $query );
			$list = [];
			while ( $row = $result -> fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[] = array ( 'id'=>$row['id'],'name'=>$row['name'] );
			}
			return $list;
		}
		
		public function selectThemeCount ()
		{
			$query = "select * from newcharges";
			$result = $this->db->query ( $query );
			$list = [];
			while ( $row = $result->fetch_array ( MYSQLI_ASSOC ) )
			{
				$list[] = array ( 'themecount'=>$row['themecount'],'india'=>$row['india'],'other'=>$row['other'] );
			}
			return $list;
		}
		
		public function selectCharges ( $themecount = 0 )
		{
			if ( $themecount > 0 )
			{
				$query = 'select india, other from 
							newcharges where themecount = '.$themecount.' and active = 1';
				$result = $this->db->query ( $query );
				$list = [];
				while ( $row = $result->fetch_array ( MYSQLI_ASSOC ) )
				{
					$list[] = array ( 'india'=>$row['india'], 'other'=>$row['other'] );
				}
				
				return $list;
			
			}
			else
			{
				return 0;
			}
		}
		
		
	}
	
	
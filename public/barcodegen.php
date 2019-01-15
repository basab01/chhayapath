<?php
	include_once "../core/config/sop-init.inc.php";
	include_once "../libs/code39/code39.php";
	
	$idn = $_SESSION['user'][0]['id'];
	if ( empty ( $idn ) )
	{
		echo 'You have to login. Go to <a href="login.php">Login Page</a>';
		exit ();
	}
	
	$im = new Images ( $dbo );
	$getImgs = [];
	$getImgs = $im -> selectBarcodeImages();
		
	$path = $_SERVER['DOCUMENT_ROOT'] .'/fip2015/public/assets/files';
	
	$flnm = $path."/"."barcode_".$idn.".pdf"; 
	$email = $_SESSION['user']['0']['email'];
	$logofile  = $_SERVER['DOCUMENT_ROOT'] .'/fip2015/logo.png';
	
	$pdf = new PDF_Code39();
	$height = 15;
	$y = 0;
	$i = 0;
	$j = 0;
	$pdf->SetY($height);
	$user = $_SESSION['user'][0]['name'];
	$user = ucwords ( $user );
	
	foreach ( $getImgs as $img )
	{
		if ( $i > 3 || $i == 0 )
		{		
			$i = 0; $height = 15; $y = 0;
			$pdf->AddPage();	
			$pdf->SetFont ( 'Arial', '', 10 );
			$pdf -> SetTextColor ( 0, 0, 0 );
			$pdf->SetY($height);
		}
		$pdf->Rect(60, 12 + 60*$i, 90, 55, 'D');
		foreach ( $img as $k => $v )
		{
			if ( $k == 'name' )
			{
				$pdf->SetFont ( 'Arial', 'B', 12 );
				$pdf -> SetTextColor ( 210, 0, 10 );
				$pdf->cell ( '190', '10', $user, 0, 1, 'C' );
				//if ($getImgs[$j][$k] <> '')
				//$pdf->Rect(60, 12, 90, 55, 'D');
			}
			else if ( $k == 'theme_name' )
			{
				$v = strtoupper ( $v );
				$pdf->SetFont ( 'Arial', '', 12 );
				$pdf -> SetTextColor ( 60, 60, 60 );
				$pdf->cell ( '190', '10', $v, 0, 1, 'C' );
				//if(!empty($v))
				//$pdf->Rect(60, 72, 90, 55, 'D');
			}
			else if ( $k == 'title' )
			{
				$pdf->SetFont ( 'Arial', 'B', 12 );
				$pdf -> SetTextColor ( 10, 20, 240 );
				$pdf->cell ( '190', '10', $v, 0, 1, 'C' );
				//if(!empty($v))
				//$pdf->Rect(60,132,90,55, 'D');
			}
			else if ( $k == 'new_name' )
			{
				$pdf -> SetTextColor ( 0, 0, 0 );
				$pdf -> Code39 ( 80, '46' + 60 * $y, $v );
				$pdf->Ln();
				$pdf->Ln();
				$pdf->Ln();
				//if(!empty($v))
				//$pdf->Rect(60,192,90,55, 'D');
			}
         	 
		}		
	    $j++;
		$i++;
		$y++;
	}
	 
	 $pdf->addpage();
	// $logofile  = $_SERVER['DOCUMENT_ROOT'] .'/basab/fip2015/logo.png';
	 $tableBorderColour = array( 50, 150, 50 );
	 $logoXPos  = 10;
	 $logoYPos  = 8;
	 $logoWidth = 190;
     $pdf->image($logofile,$logoXPos,$logoYPos,$logoWidth);	 
	 $pdf->SetFont('Arial','B', 18);
     $pdf->Ln(15);		
     $pdf->Cell( 0, 15, 'Entrant Details', 0, 0, 'C' );
    
	 $pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
     $pdf->Ln( 25 );
	 $pdf->SetFont( 'Arial', '', 9 );
	 
	$user = new User ( $dbo );
	$det = $user->selectUser ( $_SESSION['user'][0]['id'] );
	$rreg = [];
	
	$rreg['name'] = $_SESSION['user'][0]['name'];
	
	
	foreach ( $det as $dd )
	{
		$address = [];
		foreach ( $dd as $key => $val )
		{
			if ( $key == 'honour' ):
				$rreg['honour'] = trim ( $val );
			
			elseif ( $key == 'address' ) :
				$rreg['address'] = trim ( $val );
				$rreg['address'] = preg_replace ( '/[\,\\n]+/', ", ", $rreg['address'] );
				$address = explode ( ', ',$rreg['address'] );
			endif;
		}
	}
	
	$rreg['email'] = $_SESSION['user'][0]['email'];
	
	$pdf->SetLeftMargin(55);
	
	foreach ( $rreg as $key => $val ):
		$key = ucwords ( $key );
		if ( $key == 'Address' ):
			
			$pdf->Cell( 15, 4, "$key", 0, 0, 'L' );
			$pdf->Cell( 5, 4, ":", 0, 0, 'L' );
			foreach ( $address as $add ):
				$pdf->Cell ( 5, 4, $add, 0, 2, 'L' );
			endforeach;
			$pdf->Ln();
		else:
			$pdf->Cell( 15, 6, "$key", 0, 0, 'L' );
			$pdf->Cell( 5, 6, ":", 0, 0, 'L' );
			$pdf->Cell(0, 6, "$val", 0, 1, 'L' );
		endif;
	endforeach;
	
	
	$pdf->Ln(20);
	$pdf->SetX(10);
	
	$pdf->SetFont( 'Arial', 'B', 12 );
	$pdf->Cell( 0, 15, 'Photo Details', 0, 0, 'C' );
	$imgg = [];
	$hold = '';
	
	
	$pdf->SetFont( 'Arial', 'B', 9 );
	foreach ( $getImgs as $img ):
		foreach ( $img as $k=>$v ):
			if ( $k == 'theme_name' OR $k == 'title' ):
				$k = ucwords ( $k );
				if($k == 'Theme_name'):
					$imgg["$v"][] = $img['title'];
				endif;
				//$pdf->Cell( 25, 6, "$k", 0, 0, 'L' );
				//$pdf->Cell( 5, 6, ":", 0, 0, 'L' );
				//$pdf->Cell( 0, 6, "$v", 0, 1, 'L' );
			endif;
		endforeach;
	endforeach;
	
	$pdf->SetLeftMargin(20);
	$pdf->Ln(20);
	foreach ( $imgg as $kk=>$vv ):
		$pdf->SetX(70);
		$pdf->Cell( 55, 6, "Theme Name - $kk", 'BT', 1, 'L' );
		$pdf->Ln();
		foreach ( $vv as $kkk=>$vvv ):
			$kkk++;
			$pdf->SetX(75);
			$pdf->Cell( 0, 3, "$kkk) $vvv", 0, 1, 'L' );
			$pdf->Ln();
		endforeach;
		$pdf->SetX(70);
	endforeach;
	
	$pdf->Ln(20);
	
	//'No commercial value - Photographs for exhibition.'
	$pdf->SetFont( 'Arial', 'B', 12 );
	$pdf->Cell( 0, 8, "Packet Barcode", 0, 1, 'C' );
	$pdf->SetFont( 'Arial', 'B', 9 );
	
	$txt = 'FIP-2015-'.$idn.'-0-0';
	$pdf -> Code39 ( 85, '240', $txt );
		
	$pdf->Rect(60, 215, 90, 55, 'D');
	
	//print_r($address);
	
	$pdf->addpage();
	$pdf->SetY(110);
	$pdf->SetFont( 'Arial', 'B', 12 );
	$pdf->Cell( 0, 4, 'No commercial value - Photographs for exhibition', 0, 1, 'C' );
	$pdf->Ln();
	$pdf->SetX(45);
	$pdf->SetFont( 'Arial', 'B', 16 );
	$pdf->Cell( 0, 4, 'To', 0, 1, 'L' );
	$pdf->SetX(10);
	$pdf->SetFont( 'Arial', 'B', 20 );
	$pdf->Cell( 0, 15, 'Dr. B. K. SINHA', 0, 1, 'C' );
	$pdf->Cell( 0, 6, '2nd FIP Grand International Circuit 2015', 0, 1, 'C' );
	
	$pdf->SetFont( 'Arial', 'B', 11 );
	$pdf->Ln();
	$pdf->Cell( 0, 6, '9A, Arya Kumar Road, Rajendra Nagar', 0, 1, 'C' );
	$pdf->Cell( 0, 6, 'Patna 800 016, Bihar, India', 0, 1, 'C' );
	$pdf->Cell( 0, 6, 'Phone : +91 9835021092', 0, 1, 'C' );
	$pdf->Rect(35, 108, 150, 64, 'D');
	
	$pdf->Output("$flnm","");
 
 /*  
 require_once "/home6/fiporgin/php/Mail.php";
 require_once "/home6/fiporgin/php/Mail/mime.php";
							
	$host     = "mail.fip.org.in";
	$username = "fipcircuit2015@fip.org.in";
	$password = "circuit@fip$15";
	$smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////									  
	$to      = "$email";
	$from    = "fipcircuit2015@fip.org.in";
	$subject = "Bar Code Labels";
	$headers = array('To' => $to,'From' => $from,'Subject' => $subject);	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	 $txt = "Dear Participant      \r \n" ; 
	$txt .= "Your bar code labels are attached as pdf file. Take print out of all pages without resizing.\r \n"; 
	$txt .= "Cut the labels and paste the correct label at the back side of each of your print.  \r \n";
	$txt .= "Plase make sure to paste the correct label for the print. Prints with worng label or no label  \r \n";
	$txt .= "will be rejected.         - Salon Chairman  \r \n"; 
	
				$attachment[0] = $flnm;				 										 
				
				$mime = new Mail_mime();
				$mime -> setTXTBody($txt);												
									
				for($j=0;$j<1;$j++)
				{
				 $mime -> addAttachment($attachment[$j], 'application/pdf');
				}
				$body = $mime -> get();
				$headers = $mime -> headers($headers);
													  					
				$mail = $smtp->send($to, $headers, $body);
									
				
				if (PEAR::isError($mail)) {
				  echo("<p>" . $mail->getMessage() . "</p>");
					} else {
				  echo("<p style='margin:5%; text-align:center;font-size:x-large;color:#369;'>Labels in pdf file has been sent to your Email address.<br />
				  <a href='dashboard.php'>Back to dashboard</a></p>");
					}	      
*/

?>


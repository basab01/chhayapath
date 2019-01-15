<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	$uname = ($_SESSION['user'][0]['name']);
	$email = ($_SESSION['user'][0]['email']);
	$im = new Images ( $dbo );
	$list = $im->selectGroupImages($_SESSION['user'][0]['id']);
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$link = pathinfo($actual_link);
	

	$st = '';
	$st .= 'Dear '.$uname.'</br></br>' ; 
	$st .= 'Thank you for submission of your images. Wish you good luck for '.$title.'</br>'; 
	$st .= 'Smaller versions of your submitted images are attached here, in case of any'.'</br>';
	$st .= 'discrepacy please contact us.'.'</br></br>';
	$st .= '- Salon Chairman'; 
	$idn = $_SESSION['user'][0]['id'];

	
	foreach ( $list as $val )
	{
		foreach ( $val as $k=>$v )
		{
			$type = '';
			if ( $k == 'salon_type' )
			{
				$st .= '<p>'.'Section : '.$v;
				$typ = strtolower ( $v );
			}
			if ( $k == 'themes' ) $st .= 'Theme : '.$v.'</p>';
			$st .= '<blockquote>';
			if ( $k == 'title' )
			{
				$v1 = explode ( ',', $v );
			}
			if ( $k == 'image_name' )
			{
				
				$jj = explode ( ',', $v );
				
				for ( $i=0;$i<count($jj);$i++)
				{
					$st.='<img src="'.$link['dirname'].'/assets/files/'.$typ.'/R-'.$idn.'/'.$jj[$i].'" width=180/><br />"'.$v1[$i].'"<br /><br />';
				   //$st .= $v1[$i].'"<br />';	
				}
			}
			$st.= '</blockquote>';
		}
	}
		
    $html = '<html><body><p>'.$st.'</p></body></html>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once "/home5/photonet/php/Mail.php";
require_once "/home5/photonet/php/Mail/mime.php";
									

$host     = "mail.photonet.in";
$username = "chhayapathSalon@photonet.in";
$password = "4p&K;t0:I_&TA*";
$smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////									  
						$to      = "$email";
				  		$from    = "chhayapathSalon@photonet.in";
				  		$subject = "Image Submission (Do not Reply to this mail)";
				  		$headers = array('To' => $to,'From' => $from,'Subject' => $subject);	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	  					            $txt = "Dear Participant      \r \n" ; 
	$txt .= "Thank you for submission of your images. Wish you good luck for the contest. \r \n"; 
	$txt .= "Smaller versions of your submitted images are attached here, in case of any  \r \n";
	$txt .= "discrepancy please contact us.   \r \n";
	$txt .= "         - Salon Chairman, $title  \r \n"; 
	
								 										 
									$mime = new Mail_mime();
									$mime -> setTXTBody($txt);
									$mime->setHTMLBody($html);
			 
								//	for($j=0;$j< count($filename3);$j++)			
								//	{
								//	 $mime -> addAttachment($attachment[$j], 'image/jpeg');
								//	}								
									
									$body = $mime -> get();
									$headers = $mime -> headers($headers);
													  					
				  				    $mail = $smtp->send($to, $headers, $body);
									
				
								if (PEAR::isError($mail)) {
								echo("<p>" . $mail->getMessage() . "</p>");
								} else {
								echo("<p style='margin:5%; text-align:center;font-size:x-large;color:#369;'>Confirmation of submission has been sent to your Email address.<br />
								<a href='dashboard.php'>Back to dashboard</a></p>");
								}	
				       
        
		
////////////////////////////////////////////////////////////////////////////////////////

	
	//include_once "assets/templates/contactusTemplate.php";
	?>
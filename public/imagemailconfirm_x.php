<?php
	include_once "../core/config/sop-init.inc.php";
	define ( 'APP_DIR', __DIR__ );
	
	$uname = ($_SESSION['user'][0]['name']);
	$email = ($_SESSION['user'][0]['email']);
	$im = new Images ( $dbo );
	$list = $im->selectGroupImages($_SESSION['user'][0]['id']);
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$link = pathinfo($actual_link);
	

	$st = ''; $st1 = '';
	$st1 .= 'Dear '.$uname.'</br></br>' ; 
	$st1 .= 'Thank you for submission of your images. Wish you good luck for the '.$title.'</br>'; 
	$st1 .= ' Smaller versions of your submitted images are attached here, in case of any'.'</br>';
	$st1 .= 'discrepancy please contact us.'.'</br></br>';
	$st1 .= '- Salon Chairperson'; 
	$idn = $_SESSION['user'][0]['id'];

	
	foreach ( $list as $val )
	{
		foreach ( $val as $k=>$v )
		{
			$type = '';
			if ( $k == 'salon_type' )
			{
				$st1 .= '<p>'.'Section : '.$v;
				$typ = strtolower ( $v );
			}
			if ( $k == 'themes' ) $st1 .= 'Theme : '.$v.'</p>';
			$st1 .= '<blockquote>';
			if ( $k == 'title' )
			{
				$v1 = explode ( ',', $v );
			}
			if ( $k == 'image_name' )
			{
				
				$jj = explode ( ',', $v );
				
				for ( $i=0;$i<count($jj);$i++)
				{
	$st1.='<img src="'.$link['dirname'].'/assets/files/'.$typ.'/R-'.$idn.'/'.$jj[$i].'" width=180/><br />"'.$v1[$i].'"<br /><br />';
				   //$st .= $v1[$i].'"<br />';	
				}
			}
			$st1.= '</blockquote>';
		}
	}
	
		
    $html = '<html><body><p>'.$st1.'</p></body></html>';
    $crlf = "\n";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once "/home5/photonet/php/Mail.php";
require_once "/home5/photonet/php/Mail/mime.php";
									
/*
$smtpinfo["host"]     = "mail.fip.org.in";
$smtpinfo["username"] = "fipnational@fip.org.in";
$smtpinfo["password"] = "circuit@fip$15";
$smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
*/


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////									  
						$from    = "chhayapathSalon@photonet.in";
						$to      = "$email";
				  		$subject = "Image Submission (Do not Reply to this mail)";
				  	$headers = array ('From' => $from,'To' => $to,'Subject' => $subject,'Content-Type' => 'text/html; charset=UTF-8');	
						
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*
  $smtpinfo["host"]     = "mail.fip.org.in";
  $smtpinfo["username"] = "fipnational@fip.org.in";
  $smtpinfo["password"] = "circuit@fip$15";
  */
 
  
 // $smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
  
  $mime_params = array(
  			  'text_encoding' => '7bit',
 			  'text_charset'  => 'UTF-8',
  			  'html_charset'  => 'UTF-8',
  			  'head_charset'  => 'UTF-8'
			); 
    
  $mime = new Mail_mime($crlf);	

	$txt = "Dear Participant      \r \n" ; 
	$txt .= "Thank you for submission of your images. Wish you good luck for the contest. \r \n"; 
	$txt .= "Smaller versions of your submitted images are attached here, in case of any  \r \n";
	$txt .= "discrepancy please contact us.   \r \n";
	$txt .= "         - Salon Chairperson  \r \n"; 
   							
         $mime->setTXTBody($txt);
         $mime->setHTMLBody($html);								
									
									//$body = $mime -> get();
									//$headers = $mime -> headers($headers);
													  					
				    $body    = $mime->get($mime_params);
                                    $headers = $mime->headers($headers);									
									
						         $smtp = Mail::factory('smtp',$smtpinfo);
					                 $mail = $smtp->send($to, $headers, $body);
																		
				  				    //$mail = $smtp->send($to, $headers, $body);
									
				
								if (PEAR::isError($mail)) {
								echo("<p>" . $mail->getMessage() . "</p>");
								} else {
								echo("<p style='margin:5%; text-align:center;font-size:x-large;color:#369;'>Confirmation of submission has been sent to your Email address.<br />
								<a href='dashboard.php'>Back to dashboard</a></p>");
								}	
				       
        
		
////////////////////////////////////////////////////////////////////////////////////////

	
	//include_once "assets/templates/contactusTemplate.php";
	?>
<?php
		
	//--------------- for persons registered before -------------------
	
	error_reporting(0);
	include_once "../core/config/sop-init.inc.php";
	$conn = $dbo;
	$login= "";
    $msg = "";
	$sec_code="";
	$rslt ="";
	$code ='';
////////////////////////////////////////////////////////////////	
	if (isset($_POST) AND array_key_exists('btnForgotPasswd',$_POST))
	 {
		
	  $flag=0;
	  $newflag=0;
	  $confirm_code=md5(uniqid(rand(), true));
	  $error=array();
	  if(isset($_POST['txtEmail']))
	  {
	   $loginid=trim($_POST['txtEmail']);
	  } 
	  if(isset($_POST['sec_code']))
	  {
	   $sec_code=$_POST['sec_code'];
	   $code=$_SESSION['security_code'];
	   
      }    	
	  /*
	  //if (isset($_POST['security_code']))
	 // {
	  // $code=$_SESSION['security_code'];
     // }
      */
       
		if(empty($loginid)){
		  $error[]="Login ID can't be empty !!";
		  $flag=1;
		}
		
		if($code != $sec_code){
			$error[]="Try Again !!";
			$flag=1;
		}
	    //echo 'Code : '.$code.' and sec_code : '.$sec_code;
			//exit();
		
	   if ($flag == 0){		
		if(!preg_match("/^\w+@[\w\.]+\.[A-Za-z]{2,4}$/",$loginid)){
			$error[]="Email ID is not in correct form !!";
			$flag=1;
		  }
	   }
       
	   if ($flag == 0) {
	   $sql1 = "select eml_login,password,salutation,fname,mname,lname from registrant where eml_login = '".$loginid."'";
       $result=mysqli_query($conn,$sql1);
	   $rows_returned=mysqli_num_rows($result);

	  if($rows_returned < 1)
			{
			  $error[]="Your Email ID is not valid !! Contact us by mail";
			  $flag=1;
			}
			
       }
    	   
          if ($flag == 0) { 
			   while($row1= mysqli_fetch_array($result) )
                 {
                   $email     = $row1['eml_login'];
			       $password  = $row1['password'];
				   $salut     = $row1['salutation'];
				   $firstname = $row1['fname'];
				   $middlename= $row1['mname'];
				   $lastname  = $row1['lname'];
                 }
		  		 			  
             //$sql2= "update registrant set password_cr='".$confirm_code."', active = 0 where eml_login='".$loginid."' ";
		     //$rslt = mysqli_query($conn,$sql2);
                  $rslt = 1;
			}
        
		
		if($rslt == 1){
			
			$name = trim($firstname)." ". trim($middlename)." ".trim($lastname);
					$message='';
					$message =" Dear ".$firstname." please check your mail for verification !!";
		  
			require_once "/home5/photonet/php/Mail.php";
					$from = "chhayapathSalon@photonet.in";
					$to   = "$email";
					$subject = "Forgot Password | Verification";
					
					$body = "You have requested for your existing password! You can login with following credentials to upload your images. \r \n 
			--------------------------------------------------------------------\r \n
			     username  : ".$email."             \r \n
		             password  : ".$password."           \r \n
			--------------------------------------------------------------------\r\n ";
					
	                                $smtpinfo["host"] = "mail.photonet.in";
                                       // $smtpinfo["port"] = "587";
                                       // $smtpinfo["auth"] = true;
                                        $smtpinfo["username"] = "chhayapathSalon@photonet.in";
                                        $smtpinfo["password"] = "4p&K;t0:I_&TA*"; 
						 				
					
					$headers = array ('From' => $from,'To' => $to,'Subject' => $subject);
			//$smtp = Mail::factory('smtp',array ('host' => $host,'auth' => true,'username' => $username,'password' => $password));
					$smtp = Mail::factory('smtp',$smtpinfo);
					$mail = $smtp->send($to, $headers, $body);
					
					
				
					if (PEAR::isError($mail)) {
					echo("<p>" . $mail->getMessage() . "</p>");
					} else {
						echo("<p style='margin:5%; text-align:center;font-size:x-large;color:#369;'>Your Confirmation Link has been sent to your Email address<br />
								<a href='dashboard.php'>Back to dashboard</a></p>");
					} 
		}
		else
		{
		  $error[]="Can't Send mail !! Please contact by Email.";
		  $flag=1;
		}
 		
	}//----------------end of persons registered before but forgot password ------------------


include_once "assets/templates/forgotpassTemplate.php";

?>
	
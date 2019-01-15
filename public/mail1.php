<?php
//require_once "Mail.php";
require_once "/home5/photonet/php/Mail.php";

 $from    = "chhayapathSalon@photonet.in";
 $to      = array("mbtcnet@gmail.com","basabjyoti@gmail.com");
 $subject = "Comments from participants";
    $body    = "$mes";

    /* SMTP server name, port, user/passwd */
    $smtpinfo["host"] = "mail.photonet.in";
    //$smtpinfo["port"] = "587";
    //$smtpinfo["auth"] = true;
    $smtpinfo["username"] = "chhayapathSalon@photonet.in";
    $smtpinfo["password"] = "4p&K;t0:I_&TA*";

    $headers = array ('From' => $from,'To' => $to,'Subject' => $subject);
    $smtp = Mail::factory('smtp', $smtpinfo );

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
     } else {
      echo("<p>Message successfully sent!</p>");
	  header("Location:comments.php");
     } 
    ?>

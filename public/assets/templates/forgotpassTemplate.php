<?php
$page_title = "Chhayapath International 2017";
	if ( isset ( $_SESSION['user'] ) )
	{
		include_once "assets/usernav.inc.php";
	}
	else
	{
		include_once "assets/nav.inc.php";
	}
	$session_val = $_SESSION['token'];
	
?>

<div class="container main-container" style="min-height:550px;">
<center>
<h4><?php 
        if ( isset ( $msg ) )
        {
           echo $msg;
         } ?>
		 
		 <?php if ( isset ( $error ) AND !empty($error) ) : 
		 foreach ( $error as $k=>$v ):
			print "$k : $v<br />";
		endforeach;
		endif;
		?>
</h4>
</center>

<div align="center" class="well" style="margin:10% 0 0 0;" >

	<form class="form-search" method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] );?>">
	<div align='left'>
		<h2>Forgot Password ?</h2>
	</div>

	<div class="form-group grp">
							<div class="control-label lefty">Email *</div>
							<div class="form-control righty">
							<input name="txtEmail" id="txtEmail" size="35" type="text" data-validation="email" required>
							</div>
						</div>
	
		<!--input type='text' id='email' name='email' data-validation='email' required /></br>-->		
			
		<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
							<img src="CaptchaSecurityImages.php?width=100&height=40&characters=6" alt="captcha">
							</div>
						</div>
						
						<div class="form-group grp">
							<div class="control-label lefty">Enter Letters and Digits printed in Image </div>
							<div class="form-control righty">
							<input id="security_code" name="sec_code" type="text" required >
							</div>
						</div></br>
		<input type='submit' value='go' name ='btnForgotPasswd' class='btn btn-success' />
		
		<hr>

		
	</form>
</div>
</div>

<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
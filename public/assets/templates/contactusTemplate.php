<?php
$page_title = "Chhayapath International 2017, Contact Us";
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
        if ( isset ( $error ) AND count ( $error ) > 0 )
        {
			$msg = implode ( '<br />', $error );
			echo $msg;
         } ?>
</h4>
</center>

<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div align="center" class="well" style="margin:10% 0 0 0;" >

	<form class="form-search" method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] );?>">
	<div align='left'>
		<h2>Contact Us</h2>
	</div>

		<div class="form-group grp">
			<div class="control-label lefty">Please describe your problem</div>
			<div class="form-control righty">
				<textarea id='comment' name='comment' rows=4 cols=20 data-validation='required' required></textarea>
			</div>
		</div>
			
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
		<input type='submit' value='go' name ='btnLogin' class='btn btn-success' />
		
		<hr>

		
	</form>
</div>
</div>

<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
<?php
	//ob_start();
	$page_title = "Chhayapath International 2017, Change Password";
	include_once "assets/usernav.inc.php";
	
	/*$uu = new Registration( $dbo );
	$user = $uu -> userSelect ( $_SESSION['user'][0]['id'] );*/

	
?>

<div class="container main-container" style="min-height:570px;">
  
<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">User :  
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Change Password</h4>
<div class="uploadTable">



<?php
	if ( isset ( $message ) ):
	unset ( $_SESSION['user'] );
?>
<center><p style="color:green;"><?php echo $message; ?></p></center>
<div class="center" style="text-align : right;">
		<a href="login.php" class="btn btn-primary">Login</a>
	</div>
<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] ); ?>">
<center>
				<div id="total">
					
					
					<div class=cont>
						<h1>All fields are compulsory</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Enter Old Password *</div>
							<div class="form-control righty">
											<input name="txtOldPassword" id="txtOldPassword" size="35" maxlength="15" value="" type="password" data-validation="length" data-validation-length="min5">
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Enter New Password * <br />( 5-15 characters )</div>
							<div class="form-control righty">
											<input name="txtPassword" id="txtPassword" size="35" maxlength="15" value="" type="password" data-validation="length" data-validation-length="min5">
							</div>
						</div>
						
						<br />
						
						<div class="form-group grp">
							<div class="control-label lefty">Re-enter New Password *</div>
							<div class="form-control righty">
											<input name="txtRePassword" id="txtRePassword" size="35" maxlength="15" value="" type="password" data-validation="confirmation" data-validation-confirm="txtPassword">
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
											<input id="security_code" name="sec_code" type="text" data-validation="required">
							</div>
						</div>
					</div>
					
					
					
					<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
											<input name="btnRegistration" class="btn_green_add_search" id="btnRegistration" value="Submit Info"  type="submit" style="background-color:#ebebeb; margin:0 0 0 0;">
											<!--onclick="uploadPhoto(document.form1)"-->
														<input type="reset" name="res" value="Reset" class="btn_green_add_search" style="background-color:#ebebeb;">
														
														
						
														
							</div>
							<br>
						</div>
						
				</div>
		    
		    </center>
	</form>
	
	</div>
	
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</div>

<script>
	$ . validate ({
		modules : 'security'
	});
</script>


<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
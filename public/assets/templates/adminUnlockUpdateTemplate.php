<?php
	//ob_start();
	$page_title = "Admin update :: Upload Lock Status :: $title";
	include_once "assets/adminnav.inc.php";

	
?>

<div class="container main-container" style="min-height:570px;">
  


<div class="center" style="padding:0 5% 0 5%;">

    <h2 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Upload Lock Status Update</h2>
<div class="uploadTable">

<?php
	$uu = new User( $dbo );
	$uudetails = $uu->selectUser( $userid );
	$uudetails = $uudetails[0];
	$username = $uudetails['name'];
	$usertype = $uudetails['salontype'];
	
?>

<div class="center" style="text-align : right;">
		<a href="admindashboard.php?token=<?php echo $ttok; ?>" class="btn btn-primary">Admin Dashboard</a>
		<a href="adminuserunlock.php?type=<?php echo $type; ?>&token=<?php echo $ttok; ?>" class="btn btn-primary">User Status</a>
		<a href="adminlogout.php" class="btn btn-primary">Logout</a>
	</div>
	

<p>Name : <span style="color:crimson;"><?php echo $username; ?></span> and salon type : <span style="color:#030; font-weight:bold;"><?php echo $usertype; ?></span></p>

<form method="post" action="<?php echo $page; ?>">
<center>
				<div id="total">
					
					
					
					<input type = 'hidden' name = 'userid' id = 'userid' value = '<?php echo $userid; ?>'>
					<input type = 'hidden' name = 'usertype' id = 'usertype' value = '<?php echo $usertype; ?>'>
					
					<div class=cont>
						<h1>Select Lock Status of User</h1>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Lock / Unlock Status *</div>
							<div class="form-control righty">
								<select name="salonType" id="salonType" size="1" style="width:200px;" data-validation="required">
									<option value="">Choose...</option>
								
								<option value = "N" >Unlock</option>
								<option value = "Y" >Lock</option>
								
								</select>
							</div>
						</div>
						
						
						
						
					</div>
					
					
					
					
					
					
					
					<div class=cont>						
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
		    <p><?php echo $msg; ?></p>
		    </center>
	</form>
	<div id="info" class="pure-g" style="padding:4%">
		
		
	</div>
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
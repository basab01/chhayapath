<?php
	//ob_start();
	$page_title = $title;
	include_once "assets/usernav.inc.php";
	
	$uu = new Registration( $dbo );
	$user = $uu -> userSelect ( $_SESSION['user'][0]['id'] );
	$jj = new User ( $dbo );
	$ss = $jj -> selectSalonType ( $_SESSION['user'][0]['id'] );
	
	$stt = new Status ( $dbo );
	$kk = $stt -> checkConfirmation ( $_SESSION['user'][0]['id'], $ss );
	//echo $kk;
	
?>

<div class="container main-container" style="min-height:570px;">
  


<div class="center" style="padding:0 5% 0 5%;">

    <h2 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Update Profile</h2>
<div class="uploadTable">

<style type="text/css">
	input[type="text"] {
		text-transform:uppercase;
	}
</style>

<h3 style="padding:30px 0 0 0; font-weight:normal;color: #401080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span>, please update your profile.</h3>


<form method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] ); ?>">
<center>
				<div id="total">
					<div class=cont>
						<h1>Name and Other Details</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Salutation</div>
							<div class="form-control righty">
											<select name="cmbSalutation" data-validation="required">
											<option value="">Choose...</option>
											<?php
												$lst = [ 'Mr.', 'Ms.', 'Dr.', 'Prof.' ];
												foreach ( $lst as $ll ) : 
												if ( $ll == $user[0]['salute'] ) :
											?>
												<option value="<?php echo $ll; ?>" selected><?php echo $ll; ?></option>
												<?php
												else :
												?>
												<option value="<?php echo $ll; ?>"><?php echo $ll; ?>
												<?php
													endif;
													endforeach;
												?>
											</select>
							</div>
						</div>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">First Name *</div>
							<div class="form-control righty">
								<input name="txtFirstname" id="txtFirstname" value = "<?php echo $user[0]['fname']; ?>" size="35" type="text" maxlength = "20" data-validation="alphanumeric required" data-validation-allowing="-'">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Middle Name</div>
							<div class="form-control righty">
								<input name="txtMiddleName" value = "<?php echo $user[0]['mname']; ?>" size="35" type="text" maxlength = "15"  data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-'.">
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Last Name (Surname) *</div>
							<div class="form-control righty">
								<input name="txtLastName" id="txtLastName" value = "<?php echo $user[0]['lname']; ?>" size="35" type="text" maxlength = "20" type="text" data-validation="alphanumeric required" data-validation-allowing="-'">
							</div>
						</div>
						
						
						
						
						<!--<div class="form-group grp">
							<div class="control-label lefty">Photographic Honours</div>
							<div class="form-control righty">
								<input name="txtPhotoHonour" id="txtPhotoHonour" value = "<?php echo $user[0]['honour']; ?>" size="35" type="text" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-,./' ">
							</div>
						</div>-->
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Photographic Honours (not more than 3)</div>
							<div class="form-control righty">
								<select name="txtPhotoHonour[]" id="txtPhotoHonour" size="8" multiple >
								
								<?php
									$honours = [];
									$honours = explode(',',$user[0]['honour']);
									
									$lst = ['AFIP','EFIP','FFIP','AFIAP','EFIAP','EFIAP-B','EFIAP-S','EFIAP-G','EFIAP-PLATINUM','EFIAP-D1','EFIAP-D2','EFIAP-D3','MFIAP','ARPS','FRPS','PPSA','EPSA','MPSA','GMPSA'];
									foreach ( $lst as $ll ) : 
									if ( in_array ("$ll",$honours ) ) :
								?>
									<option value="<?php echo $ll; ?>" selected><?php echo $ll; ?></option>
									<?php
									else :
									?>
									<option value="<?php echo $ll; ?>"><?php echo $ll; ?>
									<?php
										endif;
										endforeach;
									?>
								
								</select>
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Photography Club</div>
							<div class="form-control righty">
								<input name="txtPhotoClub" id="txtPhotoClub" value = "<?php echo $user[0]['club']; ?>" size="35" type="text" maxlength = "40" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-,' ">
							</div>
						</div>
					</div>
					
					
					
					
					
					
					<div class="cont">
						<h1>Address</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Address *</div>
							<div class="form-control righty">
								<input name="txtAddrLine1" value = "<?php echo $user[0]['addr1']; ?>" size="35" type="text" maxlength = "30" data-validation="alphanumeric required" data-validation-allowing="-',\/(). " >
							</div>
						</div>
						
						<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
								<input name="txtAddrLine2"  value = "<?php echo $user[0]['addr2']; ?>" size="35"  type="text" maxlength = "30" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-',\/(). " >
							</div>
						</div>
						
						<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
								<input name="txtAddrLine3" value = "<?php echo $user[0]['addr3']; ?>" size="35"  type="text" maxlength = "30"  data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">City / Town / Village *</div>
							<div class="form-control righty">
								<input name="txtCity"  value = "<?php echo $user[0]['city']; ?>" size="25"  type="text" maxlength = "30" type="text" data-validation="alphanumeric required" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">State / Province / County *</div>
							<div class="form-control righty">
								<input name="txtState"  value = "<?php echo $user[0]['state']; ?>" size="25"  type="text" maxlength = "30" type="text" data-validation="alphanumeric required" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Zipcode *</div>
							<div class="form-control righty">
								<input name="txtZip"  value = "<?php echo $user[0]['zipcode']; ?>" size="15"  type="text" maxlength = "10" data-validation="alphanumeric required" data-validation-allowing="- ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Country *</div>
							<div class="form-control righty">
								<select name="cmbCountry" id="cmbCountry" size="1" style="width:200px;" data-validation="required">
									<option value="">Select Country</option>
								<?php
									$cc = new Registration ( $dbo );
									$countries = $cc -> selectCountry ();
									
									foreach ( $countries as $val ) :
									if ( $val['id'] == $user[0]['country'] ) :
								?>
								<option value = "<?php echo $val['id']; ?>" selected ><?php echo $val['country_name']; ?></option>
								<?php
									else :
								?>
								<option value = "<?php echo $val['id']; ?>" ><?php echo $val['country_name']; ?></option>
								<?php
									endif;
									endforeach;
									unset ( $cc ); unset ( $countries );
								?>
								</select>
							</div>
						</div>
					</div>
					
					<?php
						if ( $stt -> checkConfirmation ( $_SESSION['user'][0]['id'], $ss ) ) :
					?>
					

					<?php
						else :
					?>
						<div class=cont>
						<h1>Type of Salon</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Salon Type *</div>
							<div class="form-control righty">
								<select name="salonType" id="salonType" size="1" style="width:200px;" data-validation="required" disabled>
									<option value="">Choose...</option>
								<?php
									$cc = new Themes ( $dbo );
									$salons = $cc -> selectSalonType ();
									
									foreach ( $salons as $val ) :
									if ( $val['id'] == $user[0]['salontype'] ) :
									
								?>
								<option value = "<?php echo $val['id']; ?>" selected><?php echo $val['name']; ?></option>
								<?php
									else :
								?>
								<option value = "<?php echo $val['id']; ?>" ><?php echo $val['name']; ?></option>
								<?php
									endif;
									endforeach;
								?>
								</select>
							</div>
						</div>
						
						
						
						
						
					</div>
					
					<?php endif; ?>
					
					<div class=cont>
						<h1>Contact Informations</h1>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Email *</div>
							<div class="form-control righty">
											<input name="txtEmail" id="txtEmail" value = "<?php echo $user[0]['email']; ?>" size="35" type="text" data-validation="email" style="text-transform:none;" readonly>
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Mobile </div>
							<div class="form-control righty">
											<input name="txtMobile" id="txtMobile" value = "<?php echo $user[0]['mobile']; ?>" size="35" type="text" maxlength = "20" type="text" data-validation-optional="true" data-validation="number length" data-validation-length="10-15">
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
											<input id="security_code" name="sec_code" type="text" data-validation="required" style="text-transform:none;">
											<?php
											if (!empty ( $msg ) ) :
											?>
											<p style="color:red;"><?php echo $msg; ?></p>
											<?php
											endif;
											?>
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
	
	$(function (){
			fl = 0;
			$("select").on('change', function(e){
				$id = $(this).attr('id');
				if ( $id != 'sectionAdd' ){
					if (Object.keys($(this).val()).length > 3) {
				        $('option[value="' + $(this).val().toString().split(',')[3] + '"]').prop('selected', false);
				    }
					fl = 1;
				}else{
					fl = 0;
				}			
			});
		});
</script>


<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
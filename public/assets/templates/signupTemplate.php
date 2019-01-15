<?php
	ob_start();
	$page_title = "$title";
	include_once "assets/nav.inc.php";

	
?>

<div class="container main-container" style="min-height:570px;">
  


<div class="center" style="padding:0 5% 0 5%;">

    <h2 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Sign Up</h2>
<div class="uploadTable">

<style type="text/css">
	input[type="text"] {
		text-transform:uppercase;
	}
</style>



<form method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] ); ?>">
<center>
				<div id="total">
					<div class=cont>
						<h1>Name and Other Details</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Salutation</div>
							<div class="form-control righty">
											<select name="cmbSalutation" data-validation="required">
												<option value="Mr.">Mr.</option>
												<option value="Mrs.">Mrs.</option>
												<option value="Ms.">Ms.</option>
												<option value="Dr.">Dr.</option>
												<option value="Prof.">Prof.</option>
											</select>
							</div>
						</div>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">First Name *</div>
							<div class="form-control righty">
								<input name="txtFirstname" id="txtFirstname" size="35" type="text" maxlength = "20" data-validation="alphanumeric required" data-validation-allowing="-'">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Middle Name</div>
							<div class="form-control righty">
								<input name="txtMiddleName" size="35" type="text" maxlength = "15"  data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-'.">
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Last Name (Surname) *</div>
							<div class="form-control righty">
								<input name="txtLastName" id="txtLastName" size="35" maxlength = "20" type="text" data-validation="alphanumeric required" data-validation-allowing="-'">
							</div>
						</div>
						
						
						
						
						<!--<div class="form-group grp">
							<div class="control-label lefty">Photographic Honours</div>
							<div class="form-control righty">
								<input name="txtPhotoHonour" id="txtPhotoHonour" size="35" type="text" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-,./' ">
							</div>
						</div>-->
					<?php $honors = ['AFIP','EFIP','FFIP','AFIAP','EFIAP','EFIAP-B','EFIAP-S','EFIAP-G','EFIAP-PLATINUM','EFIAP-D1','EFIAP-D2','EFIAP-D3','MFIAP','ARPS','FRPS','PPSA','EPSA','MPSA','GMPSA']; ?>	
						
						<div class="form-group grp">
							<div class="control-label lefty">Photographic Honours (not more than 3)</div>
							<div class="form-control righty">
								<select name="txtPhotoHonour[]" id="txtPhotoHonour" size="8" multiple >
								<?php
									foreach ( $honors as $honor ): 
								?>
								<option value = "<?php echo $honor;?>" ><?php echo $honor; ?></option>
								<?php endforeach; ?>
							
									
				
								
								</select>
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Photography Club</div>
							<div class="form-control righty">
								<input name="txtPhotoClub" size="35" type="text" maxlength = "40" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-,' ">
							</div>
						</div>
					</div>
					
					
					
					
					
					
					<div class="cont">
						<h1>Address</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Address *</div>
							<div class="form-control righty">
								<input name="txtAddrLine1" size="35" type="text" maxlength = "30" data-validation="alphanumeric required" data-validation-allowing="-',\/(). " >
							</div>
						</div>
						
						<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
								<input name="txtAddrLine2"  size="35"  type="text" maxlength = "30" data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-',\/(). " >
							</div>
						</div>
						
						<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
								<input name="txtAddrLine3"  size="35"  type="text" maxlength = "30"  data-validation-optional="true" data-validation="alphanumeric" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">City / Town / Village *</div>
							<div class="form-control righty">
								<input name="txtCity"  size="25"  type="text" maxlength = "30" type="text" data-validation="alphanumeric required" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">State / Province / County *</div>
							<div class="form-control righty">
								<input name="txtState"  size="25"  maxlength = "30" type="text" data-validation="alphanumeric required" data-validation-allowing="-',\/(). ">
							</div>
						</div>
						
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Zipcode *</div>
							<div class="form-control righty">
								<input name="txtZip"  size="15"  type="text" maxlength = "10" data-validation="alphanumeric required" data-validation-allowing="- ">
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
									
								?>
								<option value = "<?php echo $val['id']; ?>" ><?php echo $val['country_name']; ?></option>
								<?php
									endforeach;
									unset ( $cc ); unset ( $countries );
								?>
								</select>
							</div>
						</div>
					</div>
					
					
					
					<div class=cont>
						<h1>Select Section</h1>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Section(s) *</div>
							<div class="form-control righty">
								<select name="salonType" id="salonType" size="1" style="width:200px;" data-validation="required" >
									
								<?php
									$cc = new Themes ( $dbo );
									$salons = $cc -> selectSalonType ();
									
									foreach ( $salons as $val ) :
									
								?>
								<option value = "<?php echo $val['id']; ?>" ><?php echo $val['name']; ?></option>
								<?php
									endforeach;
								?>
								</select>
							</div>
						</div>
						
						
						
						
					</div>
					
					
					
					<div class=cont>
						<h1>Contact Informations</h1>
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Email *</div>
							<div class="form-control righty">
											<input name="txtEmail" id="txtEmail" size="35" type="text" maxlength = "40" data-validation="email required server" data-validation-url="uniemail.php" style="text-transform:none;">
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Mobile </div>
							<div class="form-control righty">
											<input name="txtMobile" id="txtMobile" size="35"  maxlength = "20" type="text" data-validation-optional="true" data-validation="number length" data-validation-length="10-15">
							</div>
						</div>
					</div>
					
					
					
					<div class=cont>
						<h1>Create Password</h1>
						<div class="form-group grp">
							<div class="control-label lefty">Password * [ 5-15 characters (max) ]</div>
							<div class="form-control righty">
											<input name="txtPassword" id="txtPassword" size="35" maxlength="15" value="" type="password" data-validation="length" data-validation-length="min5">
							</div>
						</div>
						
						
						
						<div class="form-group grp">
							<div class="control-label lefty">Re-enter Password *</div>
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
											<input id="security_code" name="sec_code" type="text" data-validation="required" style="text-transform:none;">
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
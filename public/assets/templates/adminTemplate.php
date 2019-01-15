<?php
	//ob_start();
	$page_title = "Admin -  Chhayapath International Salon 2017";
	
	
	
?>

<div class="container main-container" style="min-height:570px; width:96%;">

<!--Top header -->
<div class="pure-g">
	<div class="pure-u-2-3">
		<div class="1-box">
		<h2 class="toptxt">18th Chhayapath International Salon 2017</h2>
		</div>
	</div>
	
	<div class="pure-u-1-3">
		<div class="1-box" style="text-align:left; padding:0 0 0 22%;">
		<div style="margin:4% 8% 0 0; height:110px;">
		<div class="holdimg" >
<!--<img src="assets/img/dj-logo.jpg" width="160" height="160" title="DJMPC Logo" alt="DJMPC Logo" style="border-radius:100%; -webkit-border-radius:100%; -webkit-box-shadow:100%; box-shadow:1px 1px 2px #ccc;"/>-->
		<br />
		
		</div>
		
		</div>
		</div>
	</div>
</div><!--end top header-->

<center><hr style="margin:0;padding:0 0 46px 0;background:#09c;width:100%; height:1px; border:none;" /></center>


<div class="bodyback">
<div class="pure-g">
	<div class="pure-u-2-5">
		<div class="1-box">
		<h3 style="padding:40px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?> ( <?php echo $_SESSION['user'][0]['username']; ?> )</span></h3>
		</div>
	</div>
	
	<div class="pure-u-3-5">
		<div class="1-box" style="text-align:right;">
		<h2 class = "dashboard">Admin Dashboard</h2>
		</div>
	</div>
</div>


<div class="pure-g" style="margin:4% 0;">
	<div class="pure-u-1-5">
	
	</div>
	
	<div class="pure-u-3-5 checkback">
		<div class="1-box" style="margin:4% 0;">
			<div>
				<a href="adminstatusdisplay.php" class="btn btn-primary mylink">Recent Upload Status</a>
				<a href="participants.php" class="btn btn-primary mylink">Participants</a>
			</div>
			
			<div>
				<a href="adminsms.php" class="btn btn-primary mylink">SMS</a>
				<a href="logout.php" class="btn btn-primary mylink">Log Out</a>
			</div>
		
			
			<div align="center" class="circuits" >
				<a href="#" id="calen"><div class="round2" style="">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">DJMPC<br />Calendar</p>
				</div></a>
				
				<a href="rules.htm" target= "_blank"><div class="round1" style="margin:5%;">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">DJMPC<br />Rules</p>
				</div></a>				
				
				</div>
		</div>
	</div>
	
	<div class="pure-u-1-5">
	
	</div>
	
</div>




</div><!-- end of body div -->

<script>
	$( function () {
		$("#calen"). on ( 'click', function ( event ) {
			event . stopPropagation ();
			$('#myModal').modal ();
		});
	});
</script>

<style>
 .modal-body dt {color:#bd01b6;}
 .modal-body dd:nth-child(4) {color:crimson; font-weight:bold;}
 .modal-body h2 {color:#003; font-weight:normal; text-align:right; padding-right:4%; text-shadow:2px 2px 2px #999;}
 .modal-body p {color:#333; font-weight:bold;}
 .modal-body p em {color:crimson;}
 footer img {border:none;}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content" > 
			<div class="modal-header" style="background:#638fc6; color:white;"> 
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
				<h4 class="modal-title" id="myModalLabel" >
				<!--48th Howrah Colour Salon 2017-->
				<center>DJ Memorial Photo Contest 2017</center>
				</h4> 
			</div> 
			<div class="modal-body">
			<!--<img src='assets/img/sopcal.jpg'>-->
			<h2>Event Calendar 2017</h2>
<dl>
<dt>Opening :</dt> <dd>1st May 2017</dd>

<dt>Closing :</dt> <dd>30th June 2017</dd>
<dt>Judging :</dt> <dd>5th - 6th July 2017</dd>
<!--
<dt>Notification :</dt> <dd>12th July 2017</dd>
<dt>Award Distribution and Exhibition :</dt> <dd>30th July 2017</dd>
<dt>Catalog Mailing :</dt> <dd>30th September 2017</dd>
-->
</dl>
<!--<p>After uploading all 4 images please make sure to click the confirm button at the bottom of the upload page to agree to the terms and conditions of the competition.</p>-->

<!--<p>Please make sure to agree to the <em>Terms and Conditions</em> of the competition by clicking the confirm button at the bottom of the upload page after uploading all 4 images.</p>-->
			</div> 
			<div class="modal-footer" style="background-color:#63c66a;"> 
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> 
			</div> 
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>
<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
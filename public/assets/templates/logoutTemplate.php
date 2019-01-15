<?php
	//ob_start();
	$page_title = "Logout Status - CIS2017";
	include_once "assets/nav.inc.php";
	
?>
<style>
	footer img {border:none;}
</style>

<div class="container main-container" style="min-height:570px; width:90%;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">




<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( Logout )</h4>
<div class="uploadTable" style="min-height:320px;">	
	
	
	<div class="center" style="text-align : right;">
		<a href="login.php" class="btn btn-primary">Login</a>
	</div>
	
	<center>
	<br /><br /><br />
	<h2 style="color:red;">You are logged out</h2>
	</center>
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</form></div>

<script>
		$(document).ready( function () {
			$('#uploadstat').DataTable();
		} );
		</script>
	



<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
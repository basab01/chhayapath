<?php
	
	$page_title = "$title, Sign Up";
	include_once "assets/adminnav.inc.php";

	
?>

<div class="container main-container" style="min-height:570px;">
  


<div class="center" style="padding:0 5% 0 5%;">

    <h2 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Admin Panel</h2>
<div class="uploadTable">





<form method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] ); ?>">
<center>
				<div id="total">
					<a href="adminuserunlock.php?type=pay&token=<?php echo $ttok; ?>" class="btn btn-primary">Lock-Unlock User</a>
					<a href="participants.php?token=<?php echo $ttok; ?>" class="btn btn-primary">Registrant Details</a>
					<a href="statusdisplayadmin.php?type=pay&token=<?php echo $ttok; ?>" class="btn btn-primary">Payment Status</a>
					<br /><br />
					<a href="adminlogout.php" class="btn btn-primary">Logout</a>
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
</script>


<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
<?php
	//ob_start();
	$page_title = "Admin Login, $title";
	if ( isset ( $_SESSION['admin'] ) )
	{
		include_once "assets/adminnav.inc.php";
	}
	else
	{
		include_once "assets/nav.inc.php";
	}
	//$session_val = $_SESSION['token'];
?>
<div class="container main-container" style="min-height:550px;">

<div align="center" class="well" style="margin:8% 0 0 0;" >
<?php
	if ( $_POST )
	{
		
		$admin = new Admin ( $dbo );
		$admusr = $admin->loginCheck ( $_POST );
		
		if ( $admin->loginCheck ( $_POST ) )
		{
			$_SESSION['admin'] = 'admn';
			$_SESSION['admintoken'] = 'admin-'.sha1(uniqid(mt_rand(),TRUE));
			
			$tok = $_SESSION['admintoken'];
			
			$msg = "<h4 style=\"color:#003;\">Go to <a href=\"admindashboard.php?token=$tok\" class=\"btn btn-primary\">Admin Dashboard.</a></h4>";
			echo $msg;
		}
		else
		{
			if ( isset ( $_SESSION['admin'] ) ) unset ( $_SESSION['admin'] );
			$msg = 'Miss it !!';
			echo $msg;
		}
		
	}
?>

	<form class="form-search" method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] );?>">
	<div align='left'>
		<h2 style="color:#006;">Admin Log In</h2>
	</div>

		<input type='text' id='admin_id' name='admin_id' placeholder='UserID' data-validation="alphanumeric required" /><br />		
		<input type='password' id='admin_pass' name='admin_pass' placeholder='Password' data-validation="required length" data-validation-length="min5" /><br /><br />
		
		<input type='submit' value='go' class='btn btn-success' />
		
		<hr>

		<div class='forgot'>
			<!--<a href='forgotpassword.php'>Forgot my password</a>-->		
		</div>

	</form>
	
</div>
<center>
<!--<p style="margin:4% 0 0 0; color:#006;">Only registered user can log in. If you are not registered then please go to <a href="signup.php">Registration</a> page</p>-->
</center>
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
<?php
	//ob_start();
	$page_title = "Chhayapath, Login";
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

<div align="center" class="well" style="margin:8% 0 0 0;" >
<?php
	/*if ( $_POST )
	{
		$user = new User( $dbo );
		$mdata = $user->loginCheck ( $_POST );
		print_r($mdata);
		
		if ( !empty ( $mdata ))
		{
			$_SESSION['user'] = $mdata;
			header("Location:dashboard.php");
		}
		else
		{
			echo "Something wrong!!";
		}
	}*/
	$pass = 'Admin1234';
	$pass = md5 ( $pass );
	//echo $pass;
?>

	<form class="form-search" method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] );?>">
	<div align='left'>
		<h2>Log In</h2>
	</div>
		<table border=0>
		<tr>
		<td>Email</td>
		<td> : </td>
		<td><input type='text' id='email' name='email' placeholder='Email' /></td>
		</tr>
		
		<tr>	
		<td>Password</td>
		<td> : </td>
		<td><input type='password' id='password' name='password' placeholder='Password' /></td>
		</tr>
		</table>
		<br /><br />
		
		<input type='submit' value='go' class='btn btn-success' />
		
		<hr>

		<div class='forgot'>
			<p style="color:#003;">Contact Salon Chairman in case you forget your password.</p>	
		</div>

	</form>
	
</div>
<center>
<p style="margin:4% 0 0 0; color:#006;">Only registered user can log in. If you are not registered then please go to <a href="signup.php">Registration</a> page</p>
</center>
</div>
<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
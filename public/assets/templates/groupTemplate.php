<?php
	//ob_start();
	$page_title = "Group Request - CIS 2017";
	if ( isset ( $_SESSION['user'] ) )
	{
		//include_once "assets/usernav.inc.php";
	}
	else
	{
		//include_once "assets/nav.inc.php";
	}
	$session_val = $_SESSION['token'];
?>
<div id="header" class="header">
&nbsp;
<div class="pure-g">

<div class="pure-u-2-3">
<h2 class="maintxt">18th Chhayapath International Salon 2017</h2>
</div>

<div class="pure-u-1-3">
	<div class="headin"><!--#4242d0, #7171fa-->
		<div class="holdimg">
			<img src="assets/img/img0009.png" width="69" />
		<br />
		FIAP/2017/418
		</div>
		<div class="holdimg">
			<img src="assets/img/img0008.png" width="69" />
		<br />
		PSA 2017-266
		</div>
		
		<div class="holdimg">
			<img src="assets/img/img0007.png" width="69" />
		<br />
		FIP/63/2017 
		</div>
	</div>
</div>
</div>
</div>
<div class="container main-container" style="min-height:520px; width:100%;background: linear-gradient(rgba(66,66,208,0.4),rgba(113,113,250,0.8));">

<div align="center" class="" style="margin:0;" >

	<div class="pure-g setpos">		
		<div class="pure-u-1-1">
		<div class="mshow">
		<p>This facility is available only to club/group entries.
<p><em>The Secretary of a club or the key person in case of group of persons</em> must write to the <strong>Salon Chairman, Chhayapath, Calcutta</strong> at the following email address requesting him to grant the <strong>club/group discount.</strong>

<p>The following information need to be provided for each entrant before registering individual entrants.

<ol>
<li>Sl. No.   </li>
<li>First Name</li>
<li>Middle Name</li>
<li>Last Name</li>
<li>Email address</li>
<li>Mobile Phone No.</li>
<li>Club Name or a group name for group of persons.</li>

<p>The request be sent to <strong>subratabysack04@yahoo.com</strong> 
and 
<strong>chhayapath.calcutta@gmail.com</strong>

<p>The individual members must register seperately at the Salon web site with individual email and mobile number and upload his/her images only after receiving approval from  Salon Chairman, Chhayapath, Calcutta</p>

<p><strong>Please note that  no two persons can have the same email address and mobile no.</strong><br /><br />

<a id="ad" class="btn btn-primary" role="button" href="index.php">Home</a>
		
</div>	


			
			
			
			
			
		
		
		
		
		</div>
	</div>
	
</div>
</div>
<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
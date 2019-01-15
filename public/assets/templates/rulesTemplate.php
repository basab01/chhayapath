<?php
	//ob_start();
	//include_once ( 'cptext.php' );
	$page_title = $title;
	if ( isset ( $_SESSION['user'] ) )
	{
		//include_once "assets/usernav.inc.php";
	}
	else
	{
		//include_once "assets/nav.inc.php";
	}
	$session_val = $_SESSION['token'];
	
	$ff = 2000;
	$lastDig = '';
	$yterm = Date('Y');
	//echo $yterm;
	$diff = ($yterm - $ff)+1;
	//echo $diff;
	
	$ar = ['1'=>'st','2'=>'nd','3'=>'rd','4'=>'th','5'=>'th','6'=>'th','7'=>'th','8'=>'th','9'=>'th','0'=>'th'];
	
	$lastDig = substr("$diff", -1 );
	$letrs = $ar[''.$lastDig.''];
	if ( strlen ( $diff ) > 1 ) $letrs = 'th';
	$word = $diff.$letrs;
?>
<div id="header" class="header">
&nbsp;
<div class="pure-g">

<div class="pure-u-2-3">
<h2 class="maintxt"><?php echo $title; ?></h2>
</div>

<div class="pure-u-1-3">
<table width=95% align=right>
	<tr valign=baseline align=center>
	
		<td style="padding:0 0%;"><img src="assets/img/img0009.png" width="69" /><br />
		<p><small><?php echo $fiap; ?></small></p></td>
		
		<td style="padding:0 0%;"><img src="assets/img/img0008.png" width="69" /><br />
		<p><small><?php echo $psa; ?></small></p></td>
		
		<td style="padding:0 0%;"><img src="assets/img/GPU-logo.png" width="69" /><br />
		<p><small><?php echo $gpu; ?></small></p></td>
		
		<td style="padding:0 0%;"><img src="assets/img/iup-logo.png" width="62" /><br />
		<p><small><?php echo $iup; ?></small></p></td>
		
		<td style="padding:0 0%;"><img src="assets/img/img0007.png" width="69" /><br />
		<p><small><?php echo $fip; ?></small></p></td>
	</tr>
</table>

	
</div>
</div>
</div>
<!--<div class="container main-container" style="min-height:520px; width:100%;background: linear-gradient(rgba(66,66,208,0.4),rgba(113,113,250,0.8));">-->

<div class="container main-container" style="min-height:520px; width:100%;background: linear-gradient(rgba(196,217,248,1.0),rgba(62,128,178,1.0));">

<div align="center" class="" style="margin:0;" >

	<div class="pure-g setpos">	
		<!--<div class="pure-u-1-2">
		
		</div>-->
		
		<div class="pure-u-1-1">
		<h2 style="font-weight:normal;">Rules</h2>
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html" target="_blank">Rules in Details</a>
		
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#cal" target="_blank">Calendar</a>
		
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#fees" target="_blank">Fees</a>
		
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#sections" target="_blank">Sections</a>
		
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#spec" target="_blank">Image Specification</a>
				
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#judges" target="_blank">Judges</a>
		
		<a id="ad" class="btn btn-primary mypure" 
		role="button" href="chhayapath_rules.html#awards" target="_blank">Awards</a>		
						
		</div>
	</div>
	         </br></br>
	     <!--<h3 style = "color:blue"> [ Last Date extended till 12/11/2016 and prints with barcode should reach Patna by 15/11/2016. ] </h3>--> 
	     <!--<h3 style = "color:blue"> [ Registration is closed. Thank you for Participation and wish you good luck. ] </h3>-->       
</div>
</div>
<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
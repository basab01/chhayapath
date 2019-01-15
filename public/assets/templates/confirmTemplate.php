<?php
	//ob_start();
	$page_title = "Confirm Photo submission - CIS2017";
	include_once "assets/usernav.inc.php";
	
?>

<div class="container main-container" style="min-height:570px;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">




<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( <?php echo ucwords ( $get_type ); ?> Section )</h4>
<div class="uploadTable">	
	<table width="100%">
		<tbody>
		
		
		 
		<div class="imgspec" style="width:80%;">
		   <h4>Thank You <span style="color:blue;"><?php echo ucwords ( strtolower ($_SESSION['user'][0]['name']) ); ?></span> for confirmation.
		   <br /><br />
		   <?php if ( $get_type == 'print' ) : ?>
		   Now please click the "Make barcode" button once to generate <br />your barcode lebels and wait for the message on screen.</br> An email will be sent automatically to you with attachment.
		   <?php endif; ?>
		   </h4> 			
		</div>
		<br></br>
		<div align = "center">
			<?php
				if ( $get_type == 'print' ) :
			?>
			<a href="barcodegen.php" class="btn btn-primary mylink">Make Barcode</a>
			<?php endif; ?>
			<a href="dashboard.php" class="btn btn-primary mylink">Dashboard</a>
		</div>
		<br />
		<div align="center">
		<p>( Please go back to "Dashboard" for details. )</p>
		</div>
		
		
	    </tbody>
	</table>
	
	
	
	
	
	
	<div id="disp" class="pure-g" style="padding:4%"></div>
	
	
	</div>
	
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</form></div>


	



<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
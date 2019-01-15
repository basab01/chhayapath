<?php
	//ob_start();
	$page_title = "The DJ Memorial Photography Contest";
	include_once "assets/usernav.inc.php";
	
?>

<div class="container main-container" style="min-height:570px;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">


<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( <?php echo ucwords ( $stype ); ?> Section )</h4>
<div class="uploadTable">	
	<table width="100%">
		<tbody>
		
		<div align = "center">
			<?php
				//$th = new Themes ( $dbo );
				$ss = new Status ( $dbo );
				if ( $ss -> checkConfirmation ( $_SESSION['user'][0]['id'], $stype ) ) :
				$str = '<a href="#" class="btn btn-primary mylink">View/Edit Images</a>';
				else :
				$str = '<a href="imageView.php?type='.$type.'" class="btn btn-primary mylink">View/Edit Images</a>';
				endif;
			?>
		
		    <?php
				//if ( $type == 1):
			?>
			<!--<a href="imageupload.php?type=1" class="btn btn-primary mylink">Upload Image</a>
			<a href="imageView.php?type=1" class="btn btn-primary mylink">View/Edit Images</a>-->
			<?php
				//endif;
			
				//if ( $type == 2):
			?>			
				<a href="imageUpload.php?type=<?php echo $type; ?>" class="btn btn-primary mylink">Upload Image</a>
				<?php echo $str; ?>
			<?php
				//endif;
			?>
				



				
			<a href="dashboard.php" class="btn btn-primary mylink">Dashboard</a>
			
		</div>
		 <br></br>
		<div class="imgspec">
		   <h4>Please ensure the following Image specifications :</h4> 
		   <br></br>
				<dl>
		          <dt>Color Space :</dt>
					<dd>RGB/sRGB </dd></br> 		
		          <dt>Horizontal Side Dimension :</dt>
					<dd>1920 pixel (max.)</dd></br>
			  <dt>Vertical Side Dimension :</dt>
					<dd>1080 pixel (max.)</dd></br>	
				  <dt>File format :</dt>
					<dd>jpg</dd> </br>
				<dt>Resolution :</dt>
					<dd>300 dpi</dd> </br>
				<dt>Compression :</dt>
					<dd>9 to 12</dd> </br>
				  <dt>File size   :</dt>
					<dd>1.5 MB maximum</dd></br>
                        <dt>File name   :</dt>
					<dd>within 36 chars</dd></br>
				<dt>Title   :</dt>
					<dd>within 30 chars</dd></br>
				
				
		</div>
		<br />
		<p>Please make sure to agree to the <em><a href="rules.htm" target="_blank">Terms and Conditions</a></em> of the competition by clicking the "All uploads are complete !!" (confirmation) button at the bottom of the upload page after uploading all images.</p>
		
	    </tbody>
	</table>
	
	
	
	
	
	
	<div id="disp" class="pure-g" style="padding:4%"></div>
	
	
	
	</div>
	
	
	
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
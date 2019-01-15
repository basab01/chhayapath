<?php
	//ob_start();
	
	$page_title = "Image Upload Section, ".$title;
	include_once "assets/usernav.inc.php";	
	
	$st = new Status ( $dbo );
	$th = new Themes ( $dbo );
	$themes = $th->themeLoad(Null,$type);

	
	
?>

<div class="container main-container" style="min-height:570px;margin-top:10px;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">


<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Upload Image ( <?php echo ucwords ( $stype ); ?> Section )</h4>
<div class="uploadTable" style="background:#fff;">


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
		
		
		


<?php
	if ( !$st -> checkConfirmation ( $_SESSION['user'][0]['id'], $stype ) ) :
?>
	<table width="100%" style="margin-top:4%;">
		<tbody>
		<tr>
			<td width="50%" valign=top>&nbsp;
				<div class="clearfix">
					<label for="salon_theme" style="font-size:large;color:#999;">Select Theme *</label>
					<select id="salon_theme" name="salon_theme" class="form-control" style="padding:.2%;font-size:large; color:blue;">
						<option selected="selected" value="">Choose...</option>
						
						<?php
							
							foreach ( $themes as $theme ) :
						?>
						<option value = "<?php echo $theme['id']; ?>"><?php echo $theme['themeName']; ?></option>
						<?php
							endforeach;
						?>
					</select>
					<input type="hidden" id="saltype" name="saltype" value="<?php echo $stype; ?>" >
				</div>
				<div class="clearfix">
					<label for="title" style="font-size:large;margin-top:3%;color:#999;">Add Title *</label>
					<input id="title" name="title" placeholder="Add Title in English language" type="text">			
				</div>
			
			</td>
			<td width="50%" height=200 valign=top>&nbsp;
				<div id="cont">
					<div id="fileuploader">Upload</div>
				</div>
			</td>
		</tr>
	</tbody>
	</table>
	<?php
		endif;
	?>
	<div class="clearfix">
		<?php
			foreach ( $themes as $tm ):
		?>
			<input id = "mtheme<?php echo $tm['id']; ?>" name = "mtheme<?php echo $tm['id']; ?>" value = "<?php echo $tm['photo_max']; ?>" type="hidden">
		<?php endforeach; ?>
			<input id="usrid" name="usrid" value = "<?php echo $_SESSION['user'][0]['id']; ?>" type="hidden">
			<input id="stype" name="stype" value = "<?php echo $type; ?>" type="hidden">
	</div>
	
	



<div id="info"></div>
<div id="status"></div>
<center><div id="errorMsg"></div></center>
</form>

<div class="displayImage">
<h1>Display Area</h1>
</div>

<div style="width:80%;">
<?php 
							
	foreach ( $themes as $theme ) :
	$ssk[] =  $theme['themeName'];
	endforeach;
	if ( $stype == 'print' ) :
?>

<p style="color:red;">After finishing image upload in <?php echo implode ( ', ', $ssk ); ?> please click "All Uploads are Complete" button once ( confirmation ). You will not be allowed to upload or edit after confirming your entries and you will be asked to generate the barcode lebels for your prints. The confirm also implies your acceptence to terms and conditions of the Circuit.</p>

<?php else : ?>

<!---Please click "All Uploads are Complete" button once ( confirmation ) after finishing image upload in all sections (<?php echo implode ( ', ', $ssk ); ?>). You will not be allowed to upload or edit after confirming your entries. This confirmation also implies your acceptence to terms and conditions of the Circuit.-->



<!--<p style="color:red;">Please click "All Uploads are Complete" button ( confirmation button ) once after finishing image upload in all Themes of your choice. This implies your acceptance to terms and conditions of the Circuit / Salon.
<br /><br />
Please note, this confirmation also lock your all type of upload and edit facilities.</p>-->
<?php endif; ?>
</div>

<div class="" style="width:80%;">

<?php
	if ( isset ( $dbo ) )
		$imgs = new Images ( $dbo );
	$idn = $_SESSION['user'][0]['id'];
	
	foreach ( $themes as $theme ) :
	$im = $imgs -> selectImages ( $theme['id'] );
	if ( !empty ( $im ) ) :
?>
<h3 id="open_h-<?php echo $theme['id']; ?>" style="font-family:serif, Times, 'Times New Roman'; color:#009; font-weight:normal;"><?php echo $theme['themeName']; ?></h3>
<div class="pure-g bseCls" id="open-<?php echo $theme['id']; ?>">
<?php
	foreach ( $im as $imm ):
?>
	<div class="pure-u-1-4 mypure">
	<img alt="<?php echo $imm['title']; ?>" id="mimg-<?php echo $imm['id']; ?>" src="assets/files/<?php echo $stype; ?>/R-<?php echo $idn; ?>/<?php echo $imm['name']; ?>">
	<p id="mtitle-<?php echo $imm['id']; ?>" class="t_class"><?php echo $imm['title']; ?></p>
	</div>
<?php
	endforeach;
?>
</div>
<?php
	else :
?>
<h3 id="open_h-<?php echo $theme['id']; ?>" style="font-family:serif, Times, 'Times New Roman'; color:#009; font-weight:normal;"><?php echo $theme['themeName']; ?></h3>
<div class="pure-g bseCls" id="open-<?php echo $theme['id']; ?>">&nbsp;</div>
<?php
	endif;
	endforeach;
?>



<p style="color:red;">Please click "All Uploads are Complete" button ( confirmation button ) once after finishing image upload in all Themes of your choice. This implies your acceptance to terms and conditions of the Circuit / Salon.
<br /><br />
Please note, this confirmation also lock your all type of upload and edit facilities.</p>



<div style="float:right;";>
<?php
	//if ( !$st -> checkConfirmation ( $_SESSION['user'][0]['id'], $stype ) ) :
?>
<a id="ad" class="btn btn-primary" role="button" href="confirm.php?type=<?php echo $stype; ?>">All Uploads are Complete</a>
<?php //endif; ?>
<a id="ad" class="btn btn-primary" role="button" href="dashboard.php">Back to Dashboard</a>
</div>


</div>



</div>

</div>

</div>

<script>
	$ ( function () {		
		$( "#title" ). click ( function ( event ) {
			event.stopPropagation();
			var themeid = $("#salon_theme").val();
			
			var re = $ . ajax ({
				type : 'get',
				url : 'checkno.php',
				data : {
					'themeid' : themeid
				},
				dataType : 'json'
			});
			
			re . done ( function ( data ) {
				mydata . check ( data );
			});
			
			re . fail ( function ( jqXHR, status, error ) {
				console.log('status :',status,'error : ',error);
			});
		});
		
		$("#salon_theme") . change ( function ( event ) {
			event.stopPropagation();
			$("#info").html ( '' );
			$("#title").val('');
			$("#title").trigger ( 'click' );
		});
		
		$("#info") . on ('click', function () {
			var themeid = $("#salon_theme").val();
			
			var ro = $ . ajax ({
				type : 'get',
				url : 'instantDisplay.php',
				data : {
					'themeid' : themeid
				},
				dataType : 'json'
			});
			
			ro . done ( function ( data ) {
				mydata . instImg ( data );
			});
		});
		
		
	
		$( "#fileuploader" ).uploadFile ({
			url : "upImages.php",
			fileName : "myfile",
			allowedTypes:"jpg,jpeg,JPG,JPEG",
			maxFileSize:1024*1024*1.5,
			showStatusAfterSuccess:false,
			dynamicFormData : function () {
				var data = {
					'themeid' : $("#salon_theme").val(),
					'title' : $("#title").val(),
					'saltyp' : $("#stype").val()
				};
				return data;
			},
			onSelect : function ( files ) {
				if ( $("#title").val() == '' || $("#salon_theme").val() == '' ) {
					alert("You must fill up the required fields");
					return false;
				}
				if ( $('#title').val().length > 35 )
				{
					alert ( 'Title must be within 35 chars' );
					return false;
				}
				if ( files[0].name.length > 36 )
				{
					alert ( 'File name must be within 36 chars' );
					return false;
				}
				
				
				return true;
			},
			dragDropStr: ' ',
			onSuccess:function(files,data,xhr)
			{
				var muserid = $("#usrid").val();
				console.log(data);
				$('#errorMsg').html(data);
				/*var dat = $("<div />", {
					html : "<div style='width:130px; float:left;'><center><img src = 'assets/files/R-"+muserid+"/"+files[0]+"' width=80><div style='clear:both;'>"+files[0]+"</div></center></div>"
				});
			  // $("#status").append ( dat );*/
			   $("#title").val('');
			   $("#title").trigger ( 'click' );
			   $('#info') . trigger ( 'click' );
			},
			multiple : false,
			maxFileCount : 1
		});
	});
</script>

<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
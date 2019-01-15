<?php
	//ob_start();
	$page_title = "Image View, ".$title;
	include_once "assets/usernav.inc.php";
	
?>

<div class="container main-container" style="min-height:570px;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">


<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">Edit / View Image ( <?php echo ucwords ( $sstype ); ?> Section )</h4>
<div class="uploadTable">
	<div class="center" style="text-align : right;">
		<a href="dashboard.php" class="btn btn-primary">Dashboard</a>
	</div>
	<table width="100%">
		<tbody>
		<tr>
			<td align="center" valign="top">&nbsp;
				<div class="clearfix">
					<label for="salon_theme" style="display:inline-block;font-size:large;color:#999;">Select Theme *</label>
					<select id="salon_theme" name="salon_theme" class="form-control" style="padding:.2%;font-size:large; color:blue;">
						<option selected="selected" value="">Choose...</option>
						
						<?php
							$th = new Themes ( $dbo );
							$themes = $th->themeLoad(Null, $type);
							foreach ( $themes as $theme ) :
							//if ( $theme['themeName'] == 'Nature' ) :
						?>
						
						
						<?php //else : ?>
						<option value = "<?php echo $theme['id']; ?>"><?php echo $theme['themeName']; ?></option>
						<?php
							//endif;
							endforeach;
						?>
					</select>			
				</div>
				
			
			</td>
		</tr>
	</tbody>
	</table>
	
	<div id="disp" class="pure-g" align="center" style="padding:4%"></div>
	</div>
	<div class="clearfix">
		<?php
			foreach ( $themes as $tm ):
		?>
			<input id = "mtheme<?php echo $tm['id']; ?>" name = "mtheme<?php echo $tm['id']; ?>" value = "<?php echo $tm['photo_max']; ?>" type="hidden">
		<?php endforeach; ?>
			<input id="usrid" name="usrid" value = "<?php echo $_SESSION['user'][0]['id']; ?>" type="hidden">
			<input id="stype" name="stype" value = "<?php echo $sstype; ?>" type="hidden">
	</div>
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</form></div>

<script>
	$ ( function () {
		$("#salon_theme") . change ( function () {
			var themeid = $("#salon_theme").val();
			
			if ( themeid != '' )
			{
			var rec = $ . ajax ({
				type : 'get',
				url : 'imageShow.php',
				data : {
					'themeid' : themeid
				},
				dataType : 'json'
			});
			
			rec . done ( function ( data ) {
				mydata . imageShow ( data );
				$("a[role='button']").on( 'click', function(){
					$ev = $ ( this );
					var type = $ev . attr ( 'id' );
					if ( type . match (/edit-/)) {
						mydata . modalShow ( $ev );
						$("#titleEdit") . on ( 'click', function ( event ) {
							event.stopPropagation();
							mydata . titleChange ();
						});
					}
					else if ( type . match ( /delete-/ )) {
						mydata . imageDelete ( $ev );
					}
					return false;
				});
			});
			
			rec . fail ( function ( jqXHR, status, error ) {
				console.log('status :',status,'error : ',error);
			});
			}
		});	
		
		
		$("body") . ready ( function () {
				$("#salon_theme").trigger ( 'change' );
			});
	});
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
				<h4 class="modal-title" id="myModalLabel">Edit Image Title</h4> 
			</div> 
			<div class="modal-body">Add some text here</div> 
			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				<button type="button" class="btn btn-primary" id="titleEdit">Submit changes</button> 
			</div> 
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>


<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
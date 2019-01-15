<?php
	//ob_start();
	$page_title = "Manage SMS - DJ Memorial Photography Contest 2017";
	if ( !isset ( $msg ) )
		$msg = '';
		
	if ( isset ( $_GET['message'] ) )
		$msg = urldecode($_GET['message']);
	
	$list = $ss->selectPerson();
	//print_r($list);
?>

<div class="container main-container" style="min-height:570px; width:96%;">

<!--Top header -->
<div class="pure-g">
	<div class="pure-u-2-3">
		<div class="1-box">
		<h2 class="toptxt">DJ Memorial Photography Contest 2017</h2>
		</div>
	</div>
	
	<div class="pure-u-1-3">
		<div class="1-box" style="text-align:left; padding:0 0 0 22%;">
		<div style="margin:4% 8% 0 0; height:110px;">
		<div class="holdimg" >
			<img src="assets/img/dj-logo.jpg" width="160" height="160" title="DJMPC Logo" alt="DJMPC Logo" style="border-radius:100%; -webkit-border-radius:100%; -webkit-box-shadow:100%; box-shadow:1px 1px 2px #ccc;"/>
		<br />
		
		</div>
		
		</div>
		</div>
	</div>
</div><!--end top header-->

<center><hr style="margin:0;padding:0 0 46px 0;background:#09c;width:100%; height:1px; border:none;" /></center>


<div class="bodyback">
<div class="pure-g">
	<div class="pure-u-2-5">
		<div class="1-box">
		<h3 style="padding:40px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?> ( <?php echo $_SESSION['user'][0]['username']; ?> )</span></h3>
		</div>
	</div>
	
	<div class="pure-u-3-5">
		<div class="1-box" style="text-align:right;">
		<h2 class = "dashboard">MANAGE SMS FORM</h2>
		</div>
	</div>
</div>


<div class="pure-g" style="margin:4% 0;">
	<div class="pure-u-1-5">
	
	</div>
	
	<div class="pure-u-3-5 checkback">
		<?php echo $msg; ?>
		<div class="1-box" style="margin:1% 0;">
			<form class="form-search" method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] );?>">
				<div align='center'>
					<h2>SMS Phonebook Management System</h2>
				</div>
				<br /><br />
					<?php if ($flag == true ): ?>
					<input type="text" name="cname" id="cname" value="<?php echo $data[$editid][0]; ?>" placeholder="Type name of the receiver" />
					<br />
					<input type="text" name="cmobile" id="cmobile" value="<?php echo $data[$editid][1]; ?>" placeholder="Type Mobile no. of the receiver" />
					
					<?php else : ?>
					<input type="text" name="cname" id="cname" value="" placeholder="Type name of the receiver" />
					<br />
					<input type="text" name="cmobile" id="cmobile" value="" placeholder="Type Mobile no. of the receiver" />
					<?php endif; ?>
					<br /><br />
					
					<?php
						if ( $flag == true ):
					?>
					<input type="hidden" name="personid" id = "personid" value=<?php echo $editid; ?> />
					<input type='submit' name = 'sub' value='Update' class='btn btn-success' />
					<?php else: ?>
					
					<input type='submit' name = 'sub' value='Add' class='btn btn-success' />
					<?php endif; ?>
					<input type='reset' value='Reset' class='btn btn-success' />
					<input type="button" id="list" name="list" value="Get List" class="btn btn-primary" />
					<hr>

					<div class='forgot'>
						<a href='admin.php' class="btn btn-primary">Dashboard</a>
					</div>

				</form>
				<div id="target"></div>
			
			
		
			
			<!--<div align="center" class="circuits" >
				<a href="#" id="calen"><div class="round2" style="">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">DJMPC<br />Calendar</p>
				</div></a>
				
				<a href="rules.htm" target= "_blank"><div class="round1" style="margin:5%;">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">DJMPC<br />Rules</p>
				</div></a>				
				
				</div>-->
		</div>
	</div>
	
	<div class="pure-u-1-5">
	
	</div>
	
</div>




</div><!-- end of body div -->

<script>
	$( function () {
		$("#list"). on ( 'click', function ( event ) {
			$('#myModal').modal ();
		});		
		
	})
</script>

<script>
	/*function wait(timeout){
		var deferred = $.Deferred();
		setTimeout(deferred.resolve, timeout);
		return deferred.promise();
	}
	wait(1500).done(function(){
		$("#target").append('Timeout fired !');
	});*/
</script>

<style>
 .modal-body dt {color:#bd01b6;}
 .modal-body dd:nth-child(4) {color:crimson; font-weight:bold;}
 .modal-body h2 {color:#003; font-weight:normal; text-align:right; padding-right:4%; text-shadow:2px 2px 2px #999;}
 .modal-body p {color:#333; font-weight:bold;}
 .modal-body p em {color:crimson;}
 footer img {border:none;}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content" > 
			<div class="modal-header" style="background:#638fc6; color:white;"> 
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
				<h4 class="modal-title" id="myModalLabel" >
				<!--48th Howrah Colour Salon 2017-->
				<center>Select Recipients</center>
				</h4> 
			</div> 
			<div class="modal-body">
			
			
	<?php
			
		print '<table border=1 bordercolor=#eeeeee class=display id=uploadstat width=70% >';
		print '<thead>';
		
		print '<tr>';
		print '<th>Sl. No.</th>';
		print '<th>Mobile</th>';
		print '<th style="text-align:center;">Name</th>';
		
		print '</tr></thead>';
		print '<tdoby>';
		foreach ( $list as $key=>$val )
		{
			print '<tr>';
			
			//print '<td>'.$key.' <input type="radio" class="case" name="'.$key.'" value="'.$val[1].'"></td>';
			print '<td>'.$key.' - <a href="manageformsms.php?edit='.$key.'">Edit</a></td>';
			print '<td>'.$val[1].'</td>';
			
			print "<td>".ucwords ( strtolower ( $val[0] ) )."</td>";			
			
			
			print '</tr>';
		}
		print '</tbody>';
		print '</table>';
		
		?>
			</div> 
			<div class="modal-footer" style="background-color:#63c66a;"> 
				<button type="button" id="cck" name="cck" class="btn btn-primary" data-dismiss="modal">Submit</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> 
			</div> 
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>

<script>
		$(document).ready( function () {
			$('#uploadstat').DataTable();
		} );
		</script>
		
<SCRIPT language="javascript">

$(function(){

	// add multiple select / deselect functionality
	$("#selectall").click(function () {
		$('.case').attr('checked', this.checked);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case").click(function(){

		if($(".case").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}

	});
	
	$("#cck").click ( function () {
		var vv = '';
		$(".case:checked").each( function (){
			vv += $(this).val()+"\n";
		});	
		$("#getmobs").append(vv);
	});	
});
</SCRIPT>
<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
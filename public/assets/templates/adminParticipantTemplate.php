<?php
	//ob_start();
	$page_title = "Admin - list of participants - $title";
	include_once "assets/adminnav.inc.php";
	
	
?>

<div class="container main-container" style="min-height:570px; width:90%;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">




<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( Participant Status )</h4>
<div class="uploadTable">	
	
	
	<div class="center" style="text-align : right;">
		<a href="admindashboard.php?token=<?php echo $ttok; ?>" class="btn btn-primary">Admin Dashboard</a>
	</div>
	
	
	
	<button id="export" class="btn btn-warning">Export</button>
	<div id="disp" class="pure-g" style="padding:4%"></div>
	
	
	<?php
			$ss = new Admin ( $dbo );
			$pp = $ss -> getParticipants ();
			
			
			$us = new User ( $dbo );
			
			
			
			
			
			
		
		print '<table border=1 bordercolor=#eeeeee class="display table2excel" id=participants width=60% >';
		print '<thead>';
		
		print '<tr><th style="text-align:center;">Name</th>';
		print '<th >Usr ID</th>';
		print '<th >Country</th>';
		//print '<th >Address</th>';
		
		print '<th >Email</th>';
		print '<th>Mobile</th>';
		print '<th>Club</th>';
		print '<th>Due</th>';
		print '<th>Themes</th>';
		print '<th>Payment Details</th>';

		print '</tr></thead>';
		print '<tdoby>';
		
		foreach ( $pp as $usr )
		{
			$flag = 0;
			print '<tr>';
			
			$user_list = $us -> selectUserCountry ( $usr['user_id'] );
			print "<td>".ucwords ( strtolower ( $usr['name'] ) )."</td>";
			
			print "<td>".$usr['user_id']."</td>"; 
			print "<td>".$user_list[0]['country']."</td>";
			
			//print "<td>".$usr['address']."</td>";
			
			
			print "<td>".$usr['email']."</td>";
			print "<td>".$usr['mobile']."</td>";
			print "<td>".$usr['club']."</td>";
			
			/* Due */
			$jk = new Status ( $dbo );
			$st = $jk->getPstat ();
			$themecount = 0;
			$themecount = count ( $st[$usr['user_id']] );
			$charges = $jk->selectCharges ( $themecount );
			
			if ( $user_list[0]['country'] == 'India' ) :
				$total = $charges[0]['india'];
				$flag = 1;
			else :
				$total = $charges[0]['other'];
				$totaleuro = $jk -> getConversion ( $total );
				
			endif;
			
			/* Due end */
			
			if ( empty ( $usr['due'] ) ) $usr['due']='NA';
			else $usr['due']=$total;
			print "<td>".$usr['due']."</td>";
			
			
			
			print "<td>".$themecount."</td>";
			
			
				$list = $ss->getPaymentDetails($usr['user_id']);
			
			
			print "<td>".$list[0]['paydtl']."</td>";
			
			print '</tr>';
		}
		print '</tbody>';
		print '</table>';
		//echo $st -> checkPrintReceived ( 520 );
		?>
		
	</div>
	
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</form></div>

<script src="assets/js/jquery.table2excel.js"></script>
<script src="assets/js/tableexport-xls-bold-headers.js"></script>
<script>
		$(document).ready( function () {
			$('#participants').DataTable();
		} );
		</script>

		
<script>
	$("#export").on('click', function (){
		$(".table2excel").table2excel({
			exclude: ".noExl",
			me: "Excel Document Name",
			filename: "details"
		});
	});
</script>



<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
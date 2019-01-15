<?php
	//ob_start();
	$page_title = "Image Upload Status - DJMPC 2017";
	include_once "assets/adminnav.inc.php";
	
	$th = new Themes ( $dbo );
	$salonTps = []; 
	$ttps = [];
	$flag = 0;
	$salonTps = $th -> selectSalonType (); /* salon type array i.e. 'print', 'digital'  */
	
	$tt = new Themes ( $dbo );
	foreach ( $salonTps as $tps )
	{
		foreach ( $tps as $k=>$v )
		{
			if ( $k == 'id' ) 
			{
				$tp = $tt->themeLoad ( Null, $v );
			}
			if ( $k == 'name' ) 
			{
				$ttps[$v] = $tp;
				if ( $v == 'Print' ) $flag = 1;
			}
		}
	}
	unset ( $k ); unset ( $v ); unset ( $tps );
	
	
	$no_salon_tps = count($salonTps); 
	
	$tms = [];
	foreach ( $ttps as $kk=>$tp )
	{
		foreach ( $tp as $v )
		{
			$tms[$kk][] = $v['themeName']; /* Theme names per salon type */
		}
	}
	unset($kk);unset($tp);unset($v);
	
?>

<div class="container main-container" style="min-height:570px; width:90%;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">




<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( Image upload Status )</h4>
<div class="uploadTable">	
	
	
	<div class="center" style="text-align : right;">
		<a href="admin.php" class="btn btn-primary">Dashboard</a>
	</div>
	
	
	
	
	<div id="disp" class="pure-g" style="padding:4%"></div>
	
	<?php
			$ss = new Status ( $dbo );
			$stat = $ss -> displayStatus ();
			
			$themes = $stat['themes'];
			//print_r ( $stat );
			
			if ( $flag == 1 )
			{
				$th = array_splice ( $themes, 0, 3 );
				array_push ( $th, 'Status' );
				
				$jj = array_merge ( $th, $themes );
				$stat['themes'] = $jj; 
			}
			
			
		
		$us = new User ( $dbo );
		$st = new Status ( $dbo );
		$paid = False;
		
		print '<table border=1 bordercolor=#eeeeee class=display id=uploadstat width=70% >';
		print '<thead>';
		
		print '<tr><th rowspan=2 style="text-align:center;">Name</th>';
		print '<th rowspan=2>Country</th>';
		
		foreach ( $tms as $k=>$v )
		{
			$ll = count ( $v );
			if ( $k == 'Print' ) $ll++;
			print '<th colspan='.$ll.' style="text-align:center;">'.$k.' Section</th>';
		}
		
		//print '<th rowspan=2>Payment Status</th>';
		print '</tr>';
		
		print '<tr>';
		foreach ( $stat['themes'] as $vs )
		{
			print '<th>'.$vs.'</th>';
		}
		print '</tr></thead>';
		print '<tdoby>';
		foreach ( $stat['users'] as $usr )
		{
			$st -> checkPrintReceived ( $usr );
			print '<tr>';
			
			$user_list = $us -> selectUserCountry ( $usr );
			print "<td>".ucwords ( strtolower ( $user_list[0]['name'] ) )."</td>";
			
			print "<td>".$user_list[0]['country']."</td>";
			
			foreach ( $stat['themes'] as $vl )
			{
				
					if ( $vl == 'Status' && $st -> checkPrintReceived ( $usr ) >= 1) print '<td>Prints Received</td>';
					else
					{
						if ( isset ( $stat['lists'][$usr][$vl] ) )
						{
							print '<td>'.$stat['lists'][$usr][$vl].'</td>';
						}
						else
						{
							print '<td>-</td>';
						}
					}
			}
			
			//if ( $paid ) print '<td>Paid</td>';
			//else print '<td>Being Checked</td>';
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

<script>
		$(document).ready( function () {
			$('#uploadstat').DataTable();
		} );
		</script>
	



<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
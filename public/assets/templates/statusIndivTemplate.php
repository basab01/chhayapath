<?php
	//ob_start();
	$page_title = "$page_title, Image Upload Status";
	include_once "assets/usernav.inc.php";
	
	$im = new Images ( $dbo );
	$num = $im -> checkImage ( $_SESSION['user'][0]['id'] );
	
	//$path = $_SERVER['DOCUMENT_ROOT'] .'/pad_2016/public/assets/files';
	$path = __DIR__ .'public/assets/files';
	//echo realpath(dirname(__FILE__));
	
	$salonTps = []; 
	$ttps = [];
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
			if ( $k == 'name' ) $ttps[$v] = $tp;
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

<div class="container main-container" style="min-height:570px;">
  <form method="post" autocomplete="off" enctype="multipart/formdata">


<h4 style="padding:30px 0 0 0; font-weight:normal;color: #408080;">User :  
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h4>

<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( Image upload and Payment Status )</h4>
<div class="uploadTable">	
	
	
	<div class="center" style="text-align : right;">
		<a href="dashboard.php" class="btn btn-primary">Dashboard</a>
	</div>
	
	
	
	
	<div id="disp" class="pure-g" style="padding:4%"></div>
	
	<?php
			$ss = new Status ( $dbo );
			$stat = $ss -> displayStatus ( $_SESSION['user'][0]['id'] );
			
		
		$us = new User ( $dbo );
		$paid = False;
		
		
		
		print '<table border=1 bordercolor=#cccccc class=imglist >';
		print '<thead>';
		print '<caption>Image Upload Status</caption>';
		print '<tr><th rowspan=2 style="text-align:center;">Name</th>';
		print '<th rowspan=2>Country</th>';
		
		foreach ( $tms as $k=>$v )
		{
			$ll = count ( $v );
			print '<th colspan='.$ll.' style="text-align:center;">'.$k.' Section</th>';
		}
		
		//print '<th colspan=3 style="text-align:center;">Digital Section</th>';
		print '<th rowspan=2>Payment Status</th></tr>';
		print '<tr>';
		foreach ( $stat['themes'] as $vs ) print '<th>'.$vs.'</th>';
		print '</tr></thead>';
		print '<tdoby>';
		foreach ( $stat['users'] as $usr )
		{
			$paystat = $ss->selectPaymentStatus($usr);
			
			
			if( $paystat[$usr][0]['payment_digital'] > 0 )
			{
				$paid = True;
			}
			else
			{
				$paid = False;
			}
			
			print '<tr>';
			
			$user_list = $us -> selectUserCountry ( $usr );
			print "<td>".ucwords ( strtolower ( $user_list[0]['name'] ) )."</td>";
			
			print "<td>".$user_list[0]['country']."</td>";
			
			foreach ( $stat['themes'] as $vl )
			{
				if ( isset ( $stat['lists'][$usr][$vl] ) ) print '<td>'.$stat['lists'][$usr][$vl].'</td>';
				else print '<td>0</td>';
			}
			
			if ( $paid ) print '<td>Paid</td>';
			else print '<td>Being Checked</td>';
			print '</tr>';
		}
		print '</tbody>';
		print '</table>';
		
		
		$dhor = [];
		
		foreach ( $stat['users'] as $gg )
		{
			if ( isset ( $pstat[$gg] ) )
			{
				foreach ( $pstat[$gg] as $k=>$v )
				{
					$dhor[$gg] = $v;
				}
			}
		}
		
		
		
		
		$total = $ss -> displayPaymentStatus ();
		
		//$list = $ss -> displayList ( $_SESSION['user'][0]['id'] );
		//$total = $ss -> displayPaymentStat ( $list );
		
		$st = $ss->getPstat (); $themecount = 0;
		//echo 'Themecount : '.count ( $st[$_SESSION['user'][0]['id']] );
		$themecount = count ( $st[$_SESSION['user'][0]['id']] );
		$charges = $ss->selectCharges ( $themecount );
		//print_r ( $charges[0] );
		if ( $_SESSION['user'][0]['country'] == 'India' ) :
			$total = $charges[0]['india'];
		else :
			$total = $charges[0]['other'];
		endif;
		
		
		
		if ( $num > 0 ):
		
	?>
	<table border=1 align=center width=40% >
		<tr>
			<td style="padding:2%;">Total Participation Fees :</td>
			<td style="padding:2%;">
			<?php
				if ( $_SESSION['user'][0]['country'] == 'India' ) :
			?>
				Rs. 
			<?php
				else :
			?>
				US$ 
			<?php
				endif;
			?>
			<?php echo $total; ?>
			</td>
		</tr>
	</table>
	
	<br />
	<?php
				if ( $_SESSION['user'][0]['country'] != 'India' ) :
			?>
	<!--<center>In Euro : --><?php //echo $ss -> getConversion ( $total ); ?> <!--Euro</center>-->
	<?php endif; ?>
	<?php if ( $stype == 'Both' OR $stype == 'Print' ) : ?>
	<?php
		$pr = $ss -> checkPrintReceived ( $_SESSION['user'][0]['id'] );
		$msg = '';
		if ( $pr == 1 ) $msg = 'Print Received';
		else if ( $pr == 0 ) $msg = 'Print Not Received';
		else $msg = 'Entry Not Confirmed';
	?>
	
	<table align=center width=20% style="background:#efe; border:1px solid #ccc;">
		<tr>
			<td align="center" style="padding:2%;">
			 <?php echo $msg; ?>
			
			</td>
		</tr>
	</table>
	<?php endif; ?>
	<?php endif; ?>
	
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
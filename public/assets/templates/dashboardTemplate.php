<?php
	//ob_start();
	//include_once ( 'cptext.php' );
	$page_title = $title;
	$th = new Themes ( $dbo );
	$stype = $_SESSION['user'][0]['salontype'];
	//echo $stype;
	$st = new Status ( $dbo );
	$conf_dig = '';$conf_prn='';
	$paystat = $st->selectPaymentStatus ( $_SESSION['user'][0]['id']);
	
	if ( isset ( $paystat[$_SESSION['user'][0]['id']][0]['confirm_digital'] ) )
		$conf_dig = $paystat[$_SESSION['user'][0]['id']][0]['confirm_digital'];
	if ( isset ($paystat[$_SESSION['user'][0]['id']][0]['confirm_print']))
		$conf_prn = $paystat[$_SESSION['user'][0]['id']][0]['confirm_print'];
	
	$pay_op = 0;
	$msg = '';
	
	if ($stype == 3 && $conf_dig == 1 && $conf_prn == 1 )
	{
			$pay_op = 1;
	}
	else if ($stype == 3 && $conf_dig == 0 || $stype == 3 && $conf_prn == 0 )
	{
		$msg='Confirm Both Print and Digital Sections first';
		$pay_op = 0;
	}
	
	if ($stype == 2 && $conf_dig == 1 )
	{
		$pay_op = 1;
	}
	else if ($stype == 2 && $conf_dig == 0)
	{
		$msg='Confirm Digital Section first';
	}
	if ($stype == 1 && $conf_prn == 1 )
	{
		$pay_op = 1;
	}
	else if ( $stype == 1 && $conf_prn == 0)
	{
		$msg = 'Confirm Print Section first';
		$pay_op = 0;
	}
	
	
?>

<div class="container main-container" style="min-height:570px; width:96%;">

<!--Top header -->
<div class="pure-g tophead">
	<div class="pure-u-2-5">
		<div class="1-box">
		<h2 class="toptxt"><?php echo $dashboard_heading; ?></h2>
		</div>
	</div>
	
	<div class="pure-u-3-5">
		<div class="1-box" style="text-align:right;">
		<div style="margin:4% 0 0 0; height:110px;">
		
		
		<table width=60% align=right>
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
</div><!--end top header-->
<hr style="background:#ccc;width:100%; height:1px;" />


<div class="bodyback">
<div class="pure-g">
	<div class="pure-u-2-5">
		<div class="1-box">
		<h3 style="padding:40px 0 0 0; font-weight:normal;color: #408080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span></h3>
		</div>
	</div>
	
	<div class="pure-u-3-5">
		<div class="1-box" style="text-align:right;">
		<h2 class = "dashboard">My Dashboard</h2>
		</div>
	</div>
</div>


<div class="pure-g" style="margin:1% 0;">
	<div class="pure-u-2-5" align="center">
		<div class="1-box" style="padding:0 1%;">
		
			
			<table width=70% border=0 cellpadding=0 cellspacing=0 class="showDtl" height="330">
			<tr>
				<th colspan=1>Profile</th>
			</tr>
			
			<tr valign=top>
					
					<td>
					<p id="dis">
			<?php
				
				$print = False;
				$user = new User ( $dbo );
				$det = $user->selectUser ( $_SESSION['user'][0]['id'] );
				$val1 = '';
				foreach ( $det as $dd ):
				foreach ( $dd as $key => $val ):
				if ( $key == 'name' ):
				$val = '<strong>'.strtoupper ( trim ( $val ) ).'</strong>&nbsp;';
				$print = True;
				
				elseif ( $key == 'honour' ):
				$val = '<span class="deg">' . trim ( $val ) . '</span><br />';
				$print = True;
				
				elseif ( $key == 'address' ) :
				$val = trim ( $val );
				//echo '<pre>'.$val.'</pre>';
				$val = preg_replace ( '/\\n+/', '<br />', $val );
				$val = '<blockquote class="addr">' . strtoupper ( $val ) . '</blockquote>';
				$print = True;
				
				elseif ( $key == 'email' ):
				$val1 = '<span class="contact">Contacts</span><br />';
				$val1 .= '<blockquote class="eml">' . trim ( $val ) . '<br />';
				$val = $val1;
				$print = False;
				
				elseif ( $key == 'mobile' ) :
				$print = False;
				if ( !empty ( $val ) ) :
					$val1 .= trim ( $val ) . ' ( Mob )</blockquote>';
					$val = $val1;
					$print = True;
				else :
					$print = True;
				endif;
				
				elseif ( $key == 'club' ) :
				$val1 = '';
				$val = trim ( $val );
				if (!empty ( $val ) ):
					$val1 = '<span class="contact">Club</span><br />';
					$val1 .= '<blockquote class="eml">'. trim ( $val ) . '</blockquote>';
					$val = $val1;
					$print = True;
				else :
					$print = False;
				endif;
				
				elseif ( $key == 'salontype' ) :
				$stype = $val;
				$_SESSION['user'][0]['salontype'] = $val;
				$print = False;
				else :
				$print = True;
				endif;
				if ( $print ):
			?>
						<?php echo $val; ?>
						
				<?php
				endif;
				endforeach;
				endforeach;
			?>
			</p>
					</td>
				</tr>
			</table>		
		</div>
	</div>
	
	<div class="pure-u-1-5" style="text-align:center;">
		<div class="1-box" >
			<div style="margin:45% 8% 0 4%;">
			<h2>Go to a Section</h2>
			<?php
				if ( $stype == 1 OR $stype == 3 ):
			?>
			<a href="SectionView.php?type=1" class="btn btn-primary" style="background:#a03; color:white;margin:2% 0 2% 0;">Print Section</a>
			
			<?php
					endif;
				?>
				<br /><br />
			<?php
				if ( $stype == 2 OR $stype == 3 ):
			?>			
			<a href="SectionView.php?type=2" class="btn btn-primary" style="background:#a03; color:white;">Digital Section</a>
			<?php
				endif;
			?>
			
			<?php
				
				if ( $pay_op == 1 ) :
			?>
			<br /><br /><a href="imagemailconfirm.php" class="btn btn-primary" style="background:#a03; color:white;">Get Confirmation Mail</a>
			
			
			<?php endif; ?>
			</div>
		</div>
	</div>
	
	
	<div class="pure-u-2-5 checkback" >
		<div class="1-box">
			<div>
			<?php
				if ( $pay_op == 1 ) :
			?>
			<a href="#" class="btn btn-primary mylink">Update Profile</a>
			<?php
				else :
			?>
			<a href="profileUpdate.php" class="btn btn-primary mylink">Update Profile</a>
			<?php endif; ?>
			<a href="changePassword.php" class="btn btn-primary mylink">Change Password</a>
			</div>
		
		
		
			<div>
			
				<a href="statusindividual.php" class="btn btn-primary mylink">Status</a>
				<a href="contactus.php" class="btn btn-primary mylink">Contact Us</a>
			</div>
			
			
			<div>
		
			<?php
				if ( $pay_op == 1 ) :
			?>
				<a href="payment.php" class="btn btn-primary mylink">Make Payment</a>
			<?php
				else :
			?>
				<a href="payment.php?msg=<?php echo urlencode($msg); ?>" class="btn btn-primary mylink">Make Payment</a>
			<?php endif; ?>
			
			</div>
			
			
			<div>
			
				<a href="assets/howto/Howto.html" target="_blank" class="btn btn-primary mylink">Help Page</a>
			</div>
		
		
			<div>
			<a href="logout.php" class="btn btn-primary mylink">Log Out</a>
			</div>
		</div>
	</div>
	
</div>



<table width="100%" border="0" class="poss">
		<tbody>
		
		
		<tr>
			<td>
				&nbsp;
			</td>
			<td width=50%>
			<div align="center" class="circuits" style="margin:0 0 0 20%;">
				<a href="#" id="calen"><div class="round2" style="">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">Salon<br />Calendar</p>
				</div></a>
				
				<a href="assets/rules/rules.pdf"><div class="round1" style="margin:5%;">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;text-shadow: 1px 1px 3px #fff;">Salon<br />Rules</p>
				</div></a>
				
				<a href="#"><div class="round" style="">
					<p style="color:black; padding:0; padding:30% 0 0 0;font-size:110%;">Salon<br />Results</p>
				</div></a>
				
				
				</div>
			</td>
		</tr>
	</tbody>
	</table>
</div><!-- end of body div -->

<script>
	$( function () {
		$("#calen"). on ( 'click', function ( event ) {
			event . stopPropagation ();
			$('#myModal').modal ();
		});
	});
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
				<h4 class="modal-title" id="myModalLabel"><?php echo $dashboard_heading; ?></h4> 
			</div> 
			<div class="modal-body"><img src="assets/img/cal.jpg" /></div> 
			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div><!-- /.modal-content --> 
	</div><!-- /.modal -->
</div>


<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
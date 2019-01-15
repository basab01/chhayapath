<?php
	//ob_start();
	$page_title = "$title, Payment Status";
	include_once "assets/usernav.inc.php";
	
	$jk = new Status ( $dbo );
	$list = $jk -> selectPaymentStatus ( $_SESSION['user'][0]['id'] );
	$list1 = $jk -> displayList ( $_SESSION['user'][0]['id'] );
	$amount = $jk -> displayPaymentStat ( $list1 );
	
	
	$st = $jk->getPstat (); $themecount = 0;
	$themecount = count ( $st[$_SESSION['user'][0]['id']] );
	//echo 'Themecount : '.count ( $st[$_SESSION['user'][0]['id']] );
		
	$c_print = $list[$_SESSION['user'][0]['id']][0]['confirm_print'];
	$d_print = $list[$_SESSION['user'][0]['id']][0]['confirm_digital'];
	
	/*
	if ( $c_print > 0 || $d_print > 0 ) $mms = 'one section'.' and '.$list1['total_themes'].' themes';
	if ( $c_print > 0 && $d_print > 0 ) $mms = 'two sections'.' and '.$list1['total_themes'].' themes';
	*/
	
	if ( $c_print > 0 || $d_print > 0 ) $mms = 'one section'.' and '.$themecount.' themes';
	if ( $c_print > 0 && $d_print > 0 ) $mms = 'two sections'.' and '.$themecount.' themes';
	
	$country = $_SESSION['user'][0]['country'];
	  if ($list[$_SESSION['user'][0]['id']][0]['currency'] == 3){
	   $currency = "Rs.";}
	  else {
        $currency =	"US$"; $cval='USD'; 
		$acurrency =chr(128);$acval='Euro';} 
		
		
		
		/* new addition */
						$st = $jk->getPstat ();
						$themecount = 0;
						$themecount = count ( $st[$_SESSION['user'][0]['id']] );
						$charges = $jk->selectCharges ( $themecount );
						
						if ( $_SESSION['user'][0]['country'] == 'India' ) :
							$total = $charges[0]['india'];
						else :
							$total = $charges[0]['other'];
							$totaleuro = $jk -> getConversion ( $total );
							
						endif;
		
		
	
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="assets/js/jquery-1.8.2.min.js"></script>

<script language="javascript">
function reload1(form)
{
var val=form.currency.options[form.currency.options.selectedIndex].value;
self.location='payment.php?cval=' + val ;
}
</script>

<SCRIPT type="text/javascript">

$(document).ready(function(){
$("#status").hide();

$("#currency").change(function() { 

var scurrency = $("#currency").val();

if(scurrency.length > 0)
{
   
   
   $("#status").show();
   $("#status").html(scurrency);

 
}
else
	{
	$("#status").html('<font color="red">Please Choose Currency!!</font>');
	
	}

});

});

</SCRIPT>

</head>

<div class="container main-container" style="min-height:570px; width:90%;">
  
<h4 style="padding:30px 0 0 0; font-weight:normal;color: #401080;">Welcome 
<span style="color:crimson;"><?php echo strtoupper ($_SESSION['user'][0]['name']); ?></span> ( <?php echo $country; ?> )</h4>
<center>
<?php if ( isset ( $msg ) ) echo $msg; ?>
</center>


<div class="center" style="padding:0 5% 0 5%;">

    <h4 style="padding:0 0 20px 0; font-weight:normal; color: #408080; text-align:right;">( Entry Fees )</h4>
<div class="uploadTable">	

<?php
	if ( $str != '' ):
	echo $str;
	else :
?>	
	
	<div class="center" style="text-align : right;">
		<a href="dashboard.php" class="btn btn-primary">Dashboard</a>
	</div>
	
	<div id="disp" class="pure-g" style="padding:4%"></div>
	<h1 class="maintxt">Thank You for your participation in <?php echo $title; ?></h1>
	<div class="gpay">
		<p>You have participated in <strong><?php echo $mms; ?></strong> and you have to pay 
		<?php 
		/*
				if ($currency == 'US$')
		 		 echo $currency." ".$list[$_SESSION['user'][0]['id']][0]['payment_due'] .' ('.$list[$_SESSION['user'][0]['id']][0]['alt_value'].' '.chr(128).')' ; 
				else
				 echo $currency." ".$list[$_SESSION['user'][0]['id']][0]['payment_due'] ; 
				 */
				 
				 if ($currency == 'US$')
		   		 	echo $currency." ".$total ; 
		  		 else
		  		 	echo $currency." ".$total ; 
		?> 
		as your Entry Fee.
	
    	<?php if ($currency == 'US$') : ?>
		Payment of Fees has to be made by PayPal by overseas entrants. Please use the email <strong><!--ps.sarkar14@gmail.com and barunks@hotmail.com--></strong> for payment of fees by <strong>PayPal.</strong></p>
		<p>
		<?php else : ?>	 
		 <br /><br /><span style="color:crimson;">NEFT / RTGS Transfer is required to the following Account. No Draft or Pay Order will be accepted. For cash deposit to Bank Account, additional Rs.50/- should be paid.</span><br />
		 <dl>
		 <dt>Beneficiary Name:</dt>  <dd>Chhayapath, Calcutta</dd>
		 
		 <dt>Bank / Branch Name:</dt>  <dd>State Bank of India, Ballygunge  Branch</dd>
		 
		 <dt>IFSC Code:</dt>  <dd>  SBIN0000018</dd>
		 
		 <dt>Bank Account No.           :</dt>  <dd>  32196439263</dd>
		 </dl>
		 <?php endif; ?>
			
		
		<?php if($currency == 'Rs.') : ?>
		<p>Please input the details of your Cheque No. / DD No. / NEFT No.  to reconcile your payment.
		  </p>
		
		  <center>

	
		  <form method="post" action="<?php echo htmlspecialchars ( $_SERVER['PHP_SELF'] ); ?>">
			
			<div class=cont>						
						<div class="form-group grp">
							<div class="control-label lefty">Details</div>
							<div class="form-control righty">
											<textarea name="txtPay" id="txtPay" rows=4 cols=20 data-validation="required"></textarea>
							</div>
						</div>
			
			
						<div class="form-group grp">
							<div class="control-label lefty">&nbsp;</div>
							<div class="form-control righty">
											<input name="btnRegistration" class="btn_green_add_search" id="btnRegistration" value="Submit Info"  type="submit" style="background-color:#ebebeb; margin:0 0 0 0;">
											<!--onclick="uploadPhoto(document.form1)"-->
											<input type="reset" name="res" value="Reset" class="btn_green_add_search" style="background-color:#ebebeb;">
														
							</div>
							<br>
						</div>
			</div>
			
			
		</form>
		
		<?php else : ?>
		
		 
		
		<center>
		     <div style= "color:#006;" > 
			 
			  <?php 
			       echo "Please Pay ".$total.' '.$currency;
			  ?>
			 </div> <br/> 
			 
			<?php
			  @$cval = $_GET['cval'];
			  
		     ?>	
			 <form name= 'f1'>
			 <?php
			 echo "<select name='currency' onchange=\"reload1(this.form)\">";
			 if($cval == 'USD')
			 {
             echo "<option value=''>Choose a currency </option>";
             echo "<option value='USD' selected='selected'>US Dollar</option>";
             //echo "<option value='EUR' disable>Euro</option>";
			 }
			 else  if($cval == 'EUR')
			 {
             echo "<option value=''>Choose a currency </option>";
             echo "<option value='USD' >US Dollar</option>";
             //echo "<option value='EUR' selected='selected' disable>Euro</option>";
			 }
			 else
			 {
			  echo "<option value=''>Choose a currency </option>";
              echo "<option value='USD' >US Dollar</option>";
              //echo "<option value='EUR' >Euro</option>";
			 }
             echo "</select>";
             echo "<br />"."<br/>";
		      
			 if($cval <> '')
            { 
			echo "<div style='color:black'> Selected Currency :  $cval </div>";}
			 ?>
			 <br/>
		     </form>
			
	<?php
          if ($cval <> '')	
		  {
     ?>		  
		    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<br/><br/><br/><br/>
						
			<input type="hidden" name="cmd" value="_xclick"/>
			<input type="hidden" name="business" value="mbtcnet@gmail.com"/>
			<input type="hidden" name="lc" value="IN">
			<input type="hidden" name="item_name" value="19th Chhayapath International Salon 2018 - entry fee"/>
			<input type="hidden" name="item_number" value="1"/>
			<?php
			 if ($cval == 'USD')
			 {
			 //echo $list[$_SESSION['user'][0]['id']][0]['payment_due']
			 ?>
			  <input type='hidden' name='amount' value="<?php echo $total;?>"/>
			 <?php
			 }
			 else if ($cval == 'EUR')
			 {
			 ?>
			  <input type='hidden' name='amount' value="<?php echo $list[$_SESSION['user'][0]['id']][0]['alt_value'];?>"/>
			  <?php
			  }
			  ?>  
			<input type="hidden" name="currency_code" value="<?php echo $cval; ?> "/>
			<input name="name" value="<?php echo $sname?>" type="hidden"/>        
            <input name="email" value="<?php echo $email?>" type="hidden"/>      
			
			 
			 
			<input type="hidden" name="button_subtype" value="services"/>
			<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted"/>
			<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online."/>
		<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1"/>
		</form>	
	    <br/>
	<?php
	 }
	?>	
		</center>
		<?php endif; ?>
		
	</div>
		
	</div>
	
	
	
</div>


<div id="info"></div>
<div id="status"></div>
</form></div>

<!--<script>
		$(document).ready( function () {
			$('#uploadstat').DataTable();
		} );
		</script>-->
	

<?php endif; ?>

<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
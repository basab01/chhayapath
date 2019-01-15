<?php
	$page_title='18th Chhayapath International Salon 2017';
	$sections = ['3'=>'Monochrome', '4'=>'Colour', '5'=>'Nature', '6'=>'Photo Travel', '7'=>'Street', '8'=>'Portrait'];
	$theme=''; $typ = '';
	if ( !empty ($_GET['theme']) )
	{
		$theme = intval ( $_GET['theme'] );
	}
	else
	{
		$theme = 3;
	}
	
	
	if ( $theme == 5 ) $typ = 'ND';
	else if ( $theme == 6 ) $typ = 'PTD';
	else $typ = 'PID';
	
	$re = new Result ( $dbo );
	$getlist = $re->selectAcceptedByTheme ( $theme );
	/*print_r($getlist);
	exit();
	$getlist = $getlist[0];*/
?>

<center>
<div class='saat'>
<table>
<caption><h1><?php echo $page_title; ?> Acceptances <br /><?php echo $sections[''.$theme.'']; ?> Section (<?php echo $typ;?>)</h1></caption>
<thead>
<tr>
	<th>Country</th>
		<th>Author</th>
		<th>Image Title</th>
</tr>
</thead>
<tbody>
<?php
	$ct = ''; $au = '';
	foreach ( $getlist as $gg ):
	if ( $gg['payment_status'] == 2 ):
?>
	<tr>
		<td><?php echo $gg['country']; ?></td>
		<td><?php echo $gg['author']; ?></td>
		<td style="background:#06f; color:yellow;">Contact Salon Chairman !!</td>
	</tr>
<?php
	else :
	//endif;
?>
	<tr>
		<?php 
			if ( $ct != $gg['country'] ) :
		?>
		<td><?php echo $gg['country']; ?></td>
		<?php
			$ct = $gg['country'];
			else :
		?>
		<td>&nbsp;</td>
		<?php
			
			endif;
		?>
		
		
		<?php
			if ( $au != $gg['author'] ):
		?>
		<td><?php echo $gg['author']; ?></td>
		<?php
			$au = $gg['author'];
			else :
		?>
		<td>&nbsp;</td>
		
		<?php
			
			endif;
		?>
		
		
		<td><?php echo $gg['imageTitle']; ?></td>
	</tr>
	<?php 
	endif;
	endforeach; ?>
</table>
</div>
</center>
<br /><br /><br /><br />

<?php
	$content = ob_get_clean ();
	include_once "layout.php";
?>
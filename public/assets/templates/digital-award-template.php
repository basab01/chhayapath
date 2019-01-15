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
	$getlist = $re->selectAwardByTheme ( $theme );
	/*print_r($getlist);
	exit();
	$getlist = $getlist[0];*/
?>

<center>
<div class='saat'>
<table>
<caption><h1><?php echo $page_title; ?> Award <br /><?php echo $sections[''.$theme.'']; ?> Section (<?php echo $typ;?>)</h1></caption>
<thead>
<tr>
	<th>Award</th>
	<th><?php echo $sections[''.$theme.'']; ?></th>
</tr>
</thead>
<tbody>
<?php
	foreach ( $getlist as $gg ):
	if ( $gg['payment_status'] == 2 ):
?>
	<tr>
		<td><?php echo $gg['award_name']; ?></td>
		<td style="background:#06f; color:yellow;">
		<?php echo $gg['author']; ?>
		<br />
		Contact Salon Chairman !!
		</td>
	</tr>
<?php
	else :
?>
	<tr>
		<td><?php echo $gg['award_name']; ?></td>
		<td>Title : <?php echo $gg['imageTitle']; ?><br />
		Author : <?php echo $gg['author']; ?><br />
		Country : <?php echo $gg['country']; ?>
		</td>
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
<?php
	$file = file ( 'csvfiles/accNat.csv' );
	$kk = []; $m = 0;
	foreach ( $file as $fl )
	{
		$kk[$m] = str_getcsv ( $fl );
		$m++;
	}
	
?>

<!DOCTYPE html>
<!-- saved from url=(0063)http://localhost/basab/sop_results2017/public/digital_award.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<title>49th Howrah Colour Salon 2017</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Your invoices">
        <meta name="author" content="MBTC Team">
		
		
		<link rel="stylesheet" type="text/css" href="./awards_digital_files/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="./awards_digital_files/style.css">
		<link rel="stylesheet" type="text/css" href="./awards_digital_files/uploadfile.css">
		<link rel="stylesheet" type="text/css" href="./awards_digital_files/pure-min.css">
		<link rel="stylesheet" type="text/css" href="./awards_digital_files/jquery.dataTables.css">
		
		<script type="text/javascript" src="./awards_digital_files/jquery-1.11.0.js.download"></script>
        <script type="text/javascript" src="./awards_digital_files/bootstrap.min.js.download"></script>
		<script type="text/javascript" src="./awards_digital_files/jquery.form-validator.min.js.download"></script>
		<script type="text/javascript" src="./awards_digital_files/jquery.form.min.js.download"></script>
	</head>
	<body><center>
<div class="saat">
<!--<ul class="list-horizontal">
	<li><a href="http://localhost/basab/sop_results2017/public/awards_digital.htm#open">Open</a></li>
	<li><a href="http://localhost/basab/sop_results2017/public/awards_digital.htm#creative">Creative</a></li>
	<li><a href="http://localhost/basab/sop_results2017/public/awards_digital.htm#nature">Nature</a></li>
	<li><a href="http://localhost/basab/sop_results2017/public/awards_digital.htm#travel">Travel</a></li>
</ul>-->


<table>


<?php

	for ( $i=0; $i<count($kk); $i++ )
	{
		if ( $i == 0 )
		{
			echo '<caption><h1>'.$kk[$i][0].'</h1></caption>';
		}
		else if ( $i == 1 )
		{
			echo '<tr>';
			for ( $j = 0; $j<count($kk[$i]); $j++ )
			{
				echo '<th>'.$kk[$i][$j];
			}
			//echo '</tr>';
		}
		else
		{
			echo '<tr>';
			for ( $j = 0; $j<count($kk[$i]); $j++ )
			{
				echo '<td>'.ucwords ( $kk[$i][$j] );
			}
			//echo '</tr>';
			//echo '</tbody>';
		}
		
		
	}
?>
</table>
</div>
<br /><br />
</body>
</html>
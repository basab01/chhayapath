<div class="navbar navbar-static-top" >
    <div class="navbar-inner">
      <div class="container" style="width: 96%;">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <a href="http://www.chhayapath.org" class="brand">Chhayapath</a>        
		<div class="nav-collapse">
          <ul class="nav">                            
			<li><a href="index.php">Home</a></li>
			<?php
				if ( isset ( $type ) ) :
			?>
			<li><a href="dashboard.php?type=<?php echo $type; ?>">Dashboard</a></li>
            <li><a href="imageUpload.php?type=<?php echo $type; ?>">Image Upload</a></li>
			<?php
				$th = new Themes ( $dbo );
				$ss = new Status ( $dbo );
				if ( $ss -> checkConfirmation ( $_SESSION['user'][0]['id'], $th->saltype ( $type ) ) ) :
			?>
			<li><a href="#">View / Edit Images</li>	
			<?php
				else :
			?>
			<li><a href="imageView.php?type=<?php echo $type; ?>">View / Edit Images</a></li>
			<?php endif; ?>
			<?php
				else :
			?>
			<li><a href="dashboard.php">Dashboard</a></li>
			<!--<li><a href="imageUpload.php">Image Upload</a></li>
			<li><a href="imageView.php">View / Edit Images</a></li>-->
			<?php
				endif;
			?>
			
          </ul>

          <ul class="nav pull-right">            
			<li><a href="logout.php">Logout</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div>
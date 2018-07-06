<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
    <link rel="stylesheet" type="text/css" href="<?=HOME?>css/jjs-partners.css"/>
	</head>
	<body>
		<?php include_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div class="con-cnt-xxlrg inner-box first">
      <h2 class="h2 title-wrapper first">Partners</h2>
      <div class='col-cnt col-90'>
        <div class="col col-25">
          <a href="<?=HOME?>jjs-admin/partners/add-partner" class="btn btn-inline">Add Partner</a>
        </div>
        <div class="clear"></div>
      </div>
      <?php
        foreach ( $Partners as $partner ) {
          $partner[ "lpf_gym_name" ] = $Partner_DB_Model->gymNameToLPF( $partner[ "gym_name" ] );
          $full_logo_path = HOME . "img/uploads/" . $partner[ "logo_path" ];
          echo( "
          <a href='" . HOME . "jjs-admin/partners/partner?pid=" . $partner[ "id" ] . "' id='partner" . $partner[ "id" ] . "' class='col-cnt col-75 partner-tag mat-hov'>
            <div class='col col-25'><img class='img-xsml' src='" . $full_logo_path . "'></div>

            <div class='col col-75'><p class='col-title'>" . $partner[ "gym_name" ] . "</p></div>
            <div class='clear'></div>
          </a>
          " );
        }
      ?>
		</div>
	</body>
</html>

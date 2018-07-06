<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" );?>
    <link rel="stylesheet" type="text/css" href="<?=REL?>css/jjs-admin.css"/>
	</head>
	<body>
    <?php include_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div class="con-cnt-xxlrg inner-box first">
      <div class="col col-25"><p class="col-title">Total Accounts</p></div>
      <div class="col col-25"><p class="col-title">Free Accounts</p></div>
      <div class="col col-25"><p class="col-title">Upgraded Accounts</p></div>
      <div class="col col-25"><p class="col-title">Leads Generated</p></div>
      <div class="row-seperator"></div>
      <div class="col col-25"><p class="col-title"><?=$Partners_total?></p></div>
      <div class="col col-25"><p class="col-title"><?=$freePartners_total?></p></div>
      <div class="col col-25"><p class="col-title"><?=$upgradedPartners_total?></p></div>
      <div class="col col-25"><p class="col-title"><?=$Leads_total?></p></div>
      <div class="clear"></div>
		</div>
    </div>
	</body>
</html>

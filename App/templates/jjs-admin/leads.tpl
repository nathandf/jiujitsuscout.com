<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
		<link rel="stylesheet" type="text/css" href="<?=REL?>css/jjs-admin-leads.css"/>
	</head>
	<body>
		<?php require_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div class="con-cnt-xxlrg inner-box first">
			<h2 class="h2 title-wrapper first">Leads</h2>
			<div class="col col-33"><p class="col-title">Total Leads</p></div>
      <div class="col col-33"><p class="col-title">Generated Leads</p></div>
      <div class="col col-33"><p class="col-title">Partner Added Leads</p></div>
      <div class="row-seperator"></div>
      <div class="col col-33"><p class="col-title"><?=$Leads_data[ "total_leads" ]?></p></div>
      <div class="col col-33"><p class="col-title"><?=$Leads_data[ "generated_leads" ]?></p></div>
      <div class="col col-33"><p class="col-title"><?=$Leads_data[ "added_leads" ]?></p></div>
      <div class="clear"></div>
		</div>

		<div class="con-cnt-xxlrg inner-box first">
			<div class="lead-tag-columns">
				<p class='col col-5 text-lrg'><b>Id</b></p>
				<p class='col col-5 text-lrg'><b>Lead onwer</b></p>
				<p class='col col-5 text-lrg'><b>Name</b></p>
				<p class='col col-5 text-lrg'><b>@</b></p>
				<p class='col col-5-last text-lrg'><b>#</b></p>
				<div class='clear'></div>
			</div>
			<div class='row-seperator clear'></div>
			<?php
				$Leads = array_reverse( $Leads );
				foreach ( $Leads as $lead ) {
					echo ("
						<a href='" . HOME . "jjs-admin/leads/lead?lead_id=" . $lead[ "id" ] . "' class='lead-tag'>
							<p class='col col-5 text-med'>" . $lead[ "id" ] . "</p>
							<p class='col col-5 text-med'>" . $lead[ "gym_name" ] . "</p>
							<p class='col col-5 text-med'>" . $lead[ "name" ] . "</p>
							<p class='col col-5 text-med'>" . $lead[ "email" ] . "</p>
							<p class='col col-5-last text-med'>" . $lead[ "phone_number" ] . "</p>
							<div class='clear'></div>
						</a>
						<div class='row-seperator clear'></div>
					");
				}
			?>
		</div>
	</body>
</html>

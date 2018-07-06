<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
    <link rel="stylesheet" type="text/css" href="<?=REL?>css/call-center.css"/>
	</head>
	<body>
		<?php require_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div class="con-cnt-xxlrg inner-box first">
			<h2 class="h2 title-wrapper first">Call Center</h2>
      <div class="col col-4"><p class="col-title">Total Clients</p></div>
      <div class="col col-4"><p class="col-title"></p></div>
      <div class="col col-4"><p class="col-title">Calls Waiting</p></div>
      <div class="col col-4-last"><p class="col-title">Total Appts. Set</p></div>
      <div class="row-seperator"></div>
      <div class="col col-4"><p class="col-title">-</p></div>
      <div class="col col-4"><p class="col-title">-</p></div>
      <div class="col col-4"><p class="col-title">-</p></div>
      <div class="col col-4-last"><p class="col-title">-</p></div>
      <div class="clear"></div>
		</div>
		<div class="con-cnt-xxlrg inner-box first sms-station">
			<h2 class="h2 title-wrapper first">SMS Test Station</h2>
			<div class="con-cnt-med-plus-plus">
				<div id="conversation-box" class="conversation-box">
					<?php
						foreach ( $messages as $message ) {
							if ( $message[ "from_mdn" ] == TWILIO_PRIMARY_NUMBER ) {
								$class = "you";
							} else {
								$class="them";
							}
							echo(
							 		"<p id='" . $message[ "id" ] . "' class='" . $class . "'>" . $message[ "body" ] . "<br>
									<span class='text-xsml time'>" . date( "Y-m-d H:i:s", $message[ "time" ] ) . "</span></p>
									<div class='clear'></div>"
							 	);
						}
					?>
				</div>
			</div>
			<div class="con-cnt-med-plus-plus">
				<p class="title-wrapper">SMS Messenger</p>
				<form action="" method="post">
					<input type="hidden" name="to" value="+18122763172">
					<input type="text" name="sms_body" class="inp field-med-plus-plus" placeholder="Type your message here" required="required">
					<input type="submit" name="sendSMS" value="Send SMS" class="btn btn-cnt">
				</form>
			</div>
			<div class="clear"></div>
		</div>
	</body>
</html>

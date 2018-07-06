<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
		<link rel="stylesheet" type="text/css" href="<?=REL?>css/partner-sign-in.css"/>
	</head>
	<body>
		<?php include_once( TEMPLATES . "navigation/main-menu.php" ); ?>
		<div class="content">
			<div class="encapsulation-cnt">
				<p class="form-title">Sign in</p>
				<span> or <a class="link" href="<?=HOME?>jjs-admin/request-access">request access</a></span>
				<form action="" method="post">
					<input class="inp field-med first" type="email" name="user" value="" placeholder="Email" required="required"/>
					<div class="clear"></div>
					<input class="inp field-med" type="password" name="pass" placeholder="Password" required="required"/>
					<div class="clear"></div>
					<input class="btn btn-cnt button-med" type="submit" name="signIn" value="Submit"/>
				</form>
			</div>
		</div>
		<?php include_once( TEMPLATES . "footer.php" ); ?>
	</body>
</html>

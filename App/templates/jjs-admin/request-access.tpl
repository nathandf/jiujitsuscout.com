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
				<p class="form-title">Request Access</p>
				<span> or <a class="link" href="<?=HOME?>jjs-admin/sign-in">sign in</a></span>
				<p class="msg-err"><?=$err_msg?></p>
				<p class="msg-appr"><?=$msg?></p>
				<form action="" method="post">
					<input type="text" class="inp field-med" name="first_name" placeholder="First name" required="required"/>
					<input type="text" class="inp field-med" name="last_name" placeholder="Last name" required="required"/>
					<input type="text" class="inp field-med" name="number" placeholder="Phone number" required="required"/>
					<input type="email" class="inp field-med" name="email" placeholder="Email" required="required"/>
					<input type="password" class="inp field-med" name="password" placeholder="Password" required="required"/>
					<input type="password" class="inp field-med" name="confirm_password" placeholder="Confirm password" required="required"/>
					<input type="submit" class="btn btn-cnt button-med" name="requestAccess" value="Submit"/>
				</form>
			</div>
		</div>
	</body>
</html>

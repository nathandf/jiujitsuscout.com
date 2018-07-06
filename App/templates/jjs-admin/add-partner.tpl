<!DOCTYPE html>
<html>
	<head>
		<?php include_once( TEMPLATES . "head/admin-head.php" ); ?>
	</head>
	<body>
		<?php require_once( TEMPLATES . "navigation/admin-login-menu.php" ); ?>
		<?php include_once( TEMPLATES . "navigation/admin-menu.php" ); ?>
		<div class="con-cnt-xxlrg inner-box first">
			<div class="encapsulation-cnt">
				<h2 class="h2 title-wrapper">Add partner</h2>
				<?=$html_error_message?>
				<form action="" method="POST" id="add_user" >
					<input type="text" class="inp field-med" name="gym_name" placeholder="Gym name" required="required"/>
					<input type="text" class="inp field-med" name="name" placeholder="Contact name" required="required"/>
					<input type="text" class="inp field-med" name="email" placeholder="Email" required="required"/>
					<input type="text" class="inp field-med" name="number" placeholder="Phone number" required="required"/>
					<div class="clear"></div>
					<p class="password_label">Double check password!</p>
					<input type="text" class="inp field-med" id="password" name="password" placeholder="Password" required="required"/>
					<div class="clear"></div>
					<input type="submit" class="btn btn-cnt" name="addPartner" value="Add Partner" color="white"/>
				</form>
			</div>
		</div>
	</body>
</html>

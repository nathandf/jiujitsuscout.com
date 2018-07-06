<?php

	$roles = ['administrator','developer', 'project_manager'];
	require_once('../setup.php');

?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" >
		<script src="https://use.fontawesome.com/e86aa14892.js"></script>
		<link rel="stylesheet" type="text/css" href="index.css"/>
	</head>

	<body>


		<div id="wrapper">

			<div id="main-panel">

				<div id="nav-top">
					<ul>
						<li class="home"><a href="http://www.jiujitsuscout.com/jjs-admin/"><i class="home fa fa-home" aria-hidden="true"></i></a></li>
						<li><a href="../campaign-manager">Campaign Manager</a></li>
						<li><a href="../partners">Partners</a></li>

						<li><a href="../user-management">Users</a></li>
						<li><a href="../training">Training</a></li>
						<li><a href="../meta">Meta</a></li>
						<li><a href="../tools">Tools</a></li>
						<li><a href="logout.php">Logout</a></li>


					</ul>
				<div class="clear"></div>
			</div><!--end nav_top-->

				<div id="content">
					<h1>User Management</h1>
					<br>
					<div class="um-box">
						<?php
						$zero = 0;
						$records = $con->prepare('SELECT * FROM users WHERE user_id > :zero');
						$records->bindParam(':zero', $zero);
						$records->execute();
						while($res = $records->fetch(PDO::FETCH_ASSOC)){
							$um_user_id = $res['user_id'];
							$um_first_name = $res['first_name'];
							$um_last_name = $res['last_name'];
							$um_username = $res['username'];
							$um_user_clearance = $res['general_clearance'];
							$um_approved = $res['approved'];
							include('includes/user-tag.php');

						}
						?>
					</div>

				</div><!-- end content -->


				</div><!-- end main-panel -->
				<div class="clear"></div>

			</div><!-- end wrapper -->
	</body>

</html>

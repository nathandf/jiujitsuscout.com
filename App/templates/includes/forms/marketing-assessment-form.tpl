<div id="sign-up-form" class="sign-up-form">
	<?php
		include_once('../config/form-handling-output.php');
		include_once('../tracking/jjs-facebook-pixel-view-content.php');
	?>
	<p class="form-title" ><strong>Almost Finished!</strong></p>
	<form method="POST" action="../thank-you/">
		<input type="hidden" name="source" value="<?=$source?>"/>
		<input type="hidden" name="origin" value="<?=$origin?>"/>
		<input type="text" class="inp" name="gym_name" placeholder="Gym Name" required="required" />
		<input type="text" class="inp" name="name" placeholder="Name" required="required" />
		<input type="text" class="inp" name="email" placeholder="Email" required="required" />
		<input type="text" class="inp" name="number" placeholder="Phone Number" required="required" />
		<div class="form-hr"></div>


		<input type="submit" class="btn1" cols="30" rows="10" name="lead-submit" value="Continue" />
	</form>
	<p class="form-sub-text"><i class="fa fa-lock" aria-hidden="true"></i> Your Information is 100% Secure And Will Never Be Shared With Anyone</p>
	<p class="form-sub-text">© 2017</p>
</div><!-- end sign-up-form -->

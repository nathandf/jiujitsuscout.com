<div style="display: none;" class="modal-form">
	<div class="sign-up-form">
		<p class="form-title" ><strong>{$page->text_form|default:"Sign up to lock in your spot!"}</strong></p>
		<form method="post" action="{$HOME}martial-arts-gyms/{$business->site_slug}/thank-you">
			<input type="text" class="form-field" name="name" placeholder="First name" required="required" />
			<input type="text" class="form-field" name="email" placeholder="Email" required="required" />
			<input type="text" class="form-field" name="number" placeholder="Phone Number" required="required" />
			<div class="form-hr"></div>
			<input type="submit" class="form-button" cols="30" rows="10" name="lead-submit" value="{$page->call_to_action_form|default:'Reserve your spot'}" />
		</form>
		<p class="form-sub-text"><i class="fa fa-lock" aria-hidden="true"></i> Your Information is 100% Secure And Will Never Be Shared With Anyone</p>
		<p class="form-sub-text">© 2017</p>
	</div><!-- end sign-up-form -->
</div>

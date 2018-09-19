<div style="display: none;" class="free-class-modal lightbox">
	<p class="free-class-modal-close tc-white cursor-pt inner-pad-med floatright"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear"></div>
	<div class="free-class-container inner-pad-med con-cnt-med-plus">
		<div class="free-class-form-container con-cnt-fit push-t-med push-b-med">
			<p class="push-b-med">Try a class for free to see if this gym is the right fit for you!</p>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="capture" value="{$csrf_token}">
				<div class="clear"></div>
				<label for="" class="text-med">Name:</label>
				<div class="clear"></div>
				<input type="text" name="name" class="free-class-field">
				<div class="clear push-t"></div>
				<label for="" class="text-med">Email:</label>
				<div class="clear"></div>
				<input type="text" name="email" class="free-class-field">
				<div class="clear push-t"></div>
				<label for="" class="text-med">Phone Number:</label>
				<div class="clear"></div>
				<input type="text" name="phone" class="free-class-field">
				<div class="clear"></div>
				<p class="text-med tc-deep-blue --c-advanced-options cursor-pt push-t-med">Add a message +</p>
				<div style="display: none;" id="advanced-options" class="push-t-med">
					<label for="" class="text-med">Message:</label>
					<div class="clear"></div>
					<textarea class="free-class-field-lrg" name="message"></textarea>
				</div>
				<div class="clear"></div>
				<button type="submit" class="btn btn-inline bg-deep-blue push-t-med text-lrg" style="margin-bottom: 0;">Complete</button>
			</form>
		</div>
	</div>
</div>

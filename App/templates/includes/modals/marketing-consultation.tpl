<div id="marketing-consultation-modal" style="display: none;" class="lightbox">
	<p id="marketing-consultation-modal-close" class="tc-white cursor-pt inner-pad-med floatright"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear"></div>
	<div class="inner-pad-med con-cnt-med-plus">
		<div class="modal-form-container inner-pad-med con-cnt-fit push-b-med">
			<p class="push-b-med">Fill out the form below to schedule a marketing consultation for your martial arts business.</p>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="marketing_consultation" value="{$csrf_token}">
				<div class="clear"></div>
				<label for="" class="text-med">Name:</label>
				<div class="clear"></div>
				<input type="text" name="name" class="inp modal-form-input" required="required">
				<div class="clear push-t"></div>
				<label for="" class="text-med">Email:</label>
				<div class="clear"></div>
				<input type="text" name="email" class="inp modal-form-input" required="required">
				<div class="clear push-t"></div>
				<label for="" class="text-med">Phone Number:</label>
				<div class="clear"></div>
				<input type="text" name="phone" class="inp modal-form-input" required="required">
				<div class="clear"></div>
				<p class="text-med tc-deep-blue --c-advanced-options cursor-pt push-t-med">Optional Info +</p>
				<div style="display: none;" id="advanced-options" class="push-t-med">
					<label for="" class="text-med">Monthly Marketing Budget:</label>
					<div class="clear"></div>
					<select class="inp field-sml modal-form-input cursor-pt" name="budget" id="">
						<option value="">Select a budget</option>
						<option value="$0-$1000">$0 - $1000</option>
						<option value="$1001-$2500">$1001 - $2500</option>
						<option value="$2500-$5000">$2500 - $5000</option>
						<option value="$5001-$10,000">$5000 - $10,000</option>
						<option value="$10,001-$20,000">$10,001 - $20,000</option>
						<option value="$20,000+">$20,000+</option>
					</select>
					<div class="clear push-t"></div>
					<label for="" class="text-med"># of Students:</label>
					<div class="clear"></div>
					<select class="inp field-sml modal-form-input cursor-pt" name="students" id="">
						<option value="">Select a range</option>
						<option value="0-50">0 - 50</option>
						<option value="51-100">51 - 100</option>
						<option value="101-150">101 - 150</option>
						<option value="151-200">151 - 200</option>
						<option value="201-300">201 - 300</option>
						<option value="301-400">301 - 400</option>
						<option value="401+">401+</option>
					</select>
					<div class="clear push-t"></div>
					<label for="" class="text-med">Message:</label>
					<div class="clear"></div>
					<textarea class="inp modal-form-textarea" name="message"></textarea>
				</div>
				<div class="clear push-t"></div>
				<button type="submit" class="btn btn-inline bg-deep-blue push-t-med text-lrg" style="margin-bottom: 0;">Complete</button>
			</form>
		</div>
	</div>
</div>

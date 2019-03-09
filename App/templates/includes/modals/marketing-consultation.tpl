<div id="marketing-consultation-modal" style="display: none;" class="lightbox">
	<p id="marketing-consultation-modal-close" class="tc-white cursor-pt inner-pad-med floatright"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear"></div>
	<div class="inner-pad-med con-cnt-med-plus-plus bg-white border-std">
		<p class="push-b-med">Fill out the form below to schedule a marketing consultation for your martial arts business.</p>
		<form action="" method="post">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="marketing_consultation" value="{$csrf_token}">
			<div class="clear"></div>
			<p class="label">Name</p>
			<div class="clear"></div>
			<input type="text" name="name" class="inp inp-full" required="required">
			<div class="clear push-t"></div>
			<p class="label">Email</p>
			<div class="clear"></div>
			<input type="text" name="email" class="inp inp-full" required="required">
			<div class="clear push-t"></div>
			<p class="label">Phone Number</p>
			<div class="clear"></div>
			<input type="text" name="phone" class="inp inp-full" required="required">
			<div class="clear"></div>
			<p class="text-med tc-deep-blue --c-advanced-options cursor-pt push-t-med">Optional Info +</p>
			<div style="display: none;" id="advanced-options" class="push-t-med">
				<p class="label">Monthly Marketing Budget</p>
				<div class="clear"></div>
				<select class="inp inp-full cursor-pt" name="budget">
					<option value="" hidden="hidden">-</option>
					<option value="$0-$1000">$0 - $1000</option>
					<option value="$1001-$2500">$1001 - $2500</option>
					<option value="$2500-$5000">$2500 - $5000</option>
					<option value="$5001-$10,000">$5000 - $10,000</option>
					<option value="$10,001-$20,000">$10,001 - $20,000</option>
					<option value="$20,000+">$20,000+</option>
				</select>
				<div class="clear push-t"></div>
				<p class="label"># of Students</p>
				<div class="clear"></div>
				<select class="inp inp-full cursor-pt" name="students">
					<option value="" hidden="hidden">-</option>
					<option value="0-50">0 - 50</option>
					<option value="51-100">51 - 100</option>
					<option value="101-150">101 - 150</option>
					<option value="151-200">151 - 200</option>
					<option value="201-300">201 - 300</option>
					<option value="301-400">301 - 400</option>
					<option value="401+">401+</option>
				</select>
				<div class="clear push-t"></div>
				<p class="label">Message</p>
				<div class="clear"></div>
				<textarea class="inp inp-full textarea" name="message"></textarea>
			</div>
			<div class="clear push-t"></div>
			<button type="submit" class="btn btn-inline bg-deep-blue push-t-med text-lrg" style="margin-bottom: 0;">Complete</button>
		</form>
	</div>
</div>

<div id="actions-lead-modal" style="display: none; overflow-y: scroll;" class="lightbox actions-modal inner-pad-med">
	<p id="actions-lead-modal-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med push-t-lrg">
		<h2 class="push-b-med">Actions</h2>
		<p class="text-med">Manage</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		<a class="btn btn-inline text-med bg-deep-blue floatleft push-r-sml" href="{$HOME}account-manager/business/lead/{$lead->id}/edit"><i class="fa fa-pencil" aria-hidden="true"></i><span class="text-med-heavy push-l-sml">Edit</span></a>
		<form class="inline-form" action="{$HOME}account-manager/business/appointment/schedule">
			<input type="hidden" name="prospect_id" value="{$lead->id}">
			<button id="new-appointment" class="btn btn-inline message-btn texted action-button"><i class="fa fa-clock-o" aria-hidden="true"></i><span class="action-btn-text push-l-sml">New Appointment</span></button>
		</form>
		{if $lead->type == "lead"}
		<form class="inline-form" action="{$HOME}account-manager/business/trial/details">
			<input type="hidden" name="prospect_id" value="{$lead->id}">
			<button id="new-trial" class="btn btn-inline message-btn emailed action-button"><i class="fa fa-calendar" aria-hidden="true"></i><span class="action-btn-text push-l-sml">Start New Trial</span></button>
		</form>
		{/if}
		<a class="btn btn-inline text-med bg-algae push-r-sml" href="{$HOME}account-manager/business/lead/{$lead->id}/sequences"><i class="fa fa-plus" aria-hidden="true"></i><span class="text-med-heavy push-l-sml">Sequences</span></a>
		<div class="clear push-b-med"></div>
		<p class="text-med">Communication</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		{if isset($sms_messages)}
		<button id="send-sms" class="btn btn-inline message-btn action-button"><i class="fa fa-comments-o push-r-sml" aria-hidden="true"></i><span class="action-btn-text">Send Text</span></button>
		{/if}
		<button class="btn btn-inline message-btn action-button emailer-open bg-mango"><i class="fa fa-envelope-o push-r-sml" aria-hidden="true"></i><span class="action-btn-text">Send Email</span></button>
		<div class="push-t-med"></div>
		<p class="text-med">Record an interaction</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		<form method="post" action="#note">
			<div class="clear"></div>
			<input type="hidden" name="token" value="{$csrf_token}">
			<button type="submit" name="record_interaction" value="call" class="btn btn-inline floatleft bg-dark-mint push-r">+1 Call</button>
			<button type="submit" name="record_interaction" value="text" class="btn btn-inline floatleft bg-lavender push-r">+1 Text</button>
			<button type="submit" name="record_interaction" value="voicemail" class="btn btn-inline floatleft bg-salmon push-r">+1 Voicemail</button>
			<button type="submit" name="record_interaction" value="email" class="btn btn-inline floatleft bg-mango push-r">+1 Email</button>
		</form>
		<div class="clear"></div>
		<div class="push-t-med"></div>
		<p class="text-med">Status</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		{if $lead->status != "lost"}
		<form class="inline-form" action="{$HOME}account-manager/business/member/convert-prospect">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="prospect_id" value="{$lead->id}">
			<button id="became-member" class="btn btn-inline bg-forest message-btn --c-mp-confirm action-button"><i class="fa fa-usd" aria-hidden="true"></i><span class="action-btn-text push-l-sml">Became Member</span></button>
		</form>
		<form class="inline-form" method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="prospect_id" value="{$lead->id}">
			<input type="hidden" name="update_status" value="lost">
			<button id="lost" class="btn btn-inline notice-bg message-btn --c-status-confirm action-button"><i class="fa fa-usd" aria-hidden="true"></i><span class="action-btn-text push-l-sml">Lost / Refused</span></button>
		</form>
		{/if}
		<div class="push-t-med"></div>
		<p class="text-med">Trash</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		<form method="post" action="{$HOME}account-manager/business/lead/{$lead->id}/edit">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="trash" value="{$csrf_token}">
			<input type="hidden" name="prospect_id" value="{$lead->id}">
			<button type="submit" class="btn btn-inline bg-red floatleft --c-trash"><i class="fa fa-trash push-r-sml" aria-hidden="true"></i>Trash</button>
		</form>
		<div class="clear"></div>
	</div>
</div>

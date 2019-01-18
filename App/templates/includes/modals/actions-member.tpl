<div id="actions-member-modal" style="display: none; overflow-y: scroll;" class="lightbox actions-modal inner-pad-med">
	<p id="actions-member-modal-close" class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-xlrg bg-white inner-pad-med push-t-lrg">
		<h2 class="push-b-med">Actions</h2>
		<p class="text-med">Manage</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		<a class="btn btn-inline text-med bg-deep-blue floatleft push-r-sml" href="{$HOME}account-manager/business/member/{$member->id}/edit"><i class="fa fa-pencil" aria-hidden="true"></i><span class="text-med-heavy push-l-sml">Edit</span></a>
		<a class="btn btn-inline text-med bg-algae push-r-sml" href="{$HOME}account-manager/business/member/{$member->id}/sequences"><i class="fa fa-plus" aria-hidden="true"></i><span class="text-med-heavy push-l-sml">Sequences</span></a>
		<div class="clear push-b-med"></div>
		<p class="text-med">Communication</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		{if isset($sms_messages)}
		<button id="send-sms" class="btn btn-inline message-btn action-button"><i class="fa fa-comments-o push-r-sml" aria-hidden="true"></i><span class="action-btn-text">Send Text</span></button>
		{/if}
		<button class="btn btn-inline message-btn action-button emailer-open bg-mango"><i class="fa fa-envelope-o push-r-sml" aria-hidden="true"></i><span class="action-btn-text">Send Email</span></button>
		<div class="clear"></div>
		<div class="push-t-med"></div>
		<p class="text-med">Trash</p>
		<div class="hr-sml"></div>
		<div class="clear push-t-sml"></div>
		<form method="post" action="{$HOME}account-manager/business/member/{$member->id}/edit">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="trash" value="{$csrf_token}">
			<input type="hidden" name="member_id" value="{$member->id}">
			<button type="submit" class="btn btn-inline bg-red floatleft --c-trash"><i class="fa fa-trash push-r-sml" aria-hidden="true"></i>Trash</button>
		</form>
		<div class="clear"></div>
	</div>
</div>

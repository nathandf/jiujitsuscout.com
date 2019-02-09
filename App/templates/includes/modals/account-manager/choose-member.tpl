<div id="choose-member-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<form id="choose-member-modal-form" method="post" action="">
		<input type="hidden" name="token" value="{$csrf_token}">
		<input type="hidden" name="add_member" value="{$csrf_token}">
		<input type="hidden" id="choose-member-id" name="member_id" value="">
	</form>
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-lrg bg-white inner-pad-med border-std push-t-lrg">
		<p class="text-xlrg-heavy">Choose a member</p>
		<div class="hr-full"></div>
		{if isset($members)}
			{foreach from=$members item=member}
			<div id="lead{$member->id}" data-id="{$member->id}" class="choose-member-tag tag push-t-med mat-hov floatleft cursor-pt" style="padding-bottom: 0px;">
				<div class="lead-icon-container floatleft">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$member->first_name|substr:0:1|upper}</span>
				</div>
				<div class="lead-data floatleft">
					<p class="lead-name">{$member->getFullName()|truncate:40:"..."}</p>
					<p>{$member->phone_number|default:"Number: N/a"}</p>
					<p class="push-b-sml">{$member->email|truncate:20:"..."|default:"No email"}</p>
				</div>
			</div>
			<div class="clear"></div>
			{foreachelse}
			<p>No members available</p>
			{/foreach}
		{else}
		<p>Error: No Members Found</p>
		{/if}
	</div>
</div>

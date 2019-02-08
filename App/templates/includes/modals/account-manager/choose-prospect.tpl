<div id="choose-prospect-modal" style="display: none; overflow-y: scroll;" class="lightbox inner-pad-med">
	<form id="choose-prospect-modal-form" method="post" action="">
		<input type="hidden" name="token" value="{$csrf_token}">
		<input type="hidden" name="add_prospect" value="{$csrf_token}">
		<input type="hidden" id="choose-prospect-id" name="prospect_id" value="">
	</form>
	<p class="lightbox-close"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="con-cnt-lrg bg-white inner-pad-med border-std push-t-lrg">
		<p class="text-xlrg-heavy">Choose a prospect</p>
		<div class="hr-full"></div>
		{if isset($prospects)}
			{foreach from=$prospects item=prospect}
			<div id="lead{$prospect->id}" data-id="{$prospect->id}" class="choose-prospect-tag tag push-t-med mat-hov floatleft cursor-pt" style="padding-bottom: 0px;">
				<div class="lead-icon-container floatleft">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$prospect->first_name|substr:0:1|upper}</span>
				</div>
				<div class="lead-data floatleft">
					<p class="lead-name">{$prospect->getFullName()|truncate:40:"..."}</p>
					<p>{$prospect->phone_number|default:"Number: N/a"}</p>
					<p class="push-b-sml">{$prospect->email|truncate:20:"..."|default:"No email"}</p>
				</div>
			</div>
			<div class="clear"></div>
			{foreachelse}
			<p>No prospects available</p>
			{/foreach}
		{else}
		<p>Error: No Prospects Found</p>
		{/if}
	</div>
</div>

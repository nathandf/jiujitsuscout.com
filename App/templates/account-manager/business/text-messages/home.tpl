{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Text Messages</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/text-message/new" class="btn btn-inline mat-hov push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">Create a Text Message</span></a>
			<div class="clear push-b-med"></div>
			{foreach from=$textMessages item=textMessage}
			<a class="tag-link" href="{$HOME}account-manager/business/text-message/{$textMessage->id}/">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-lavender tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-comments"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy" href="{$HOME}account-manager/business/text-message/{$textMessage->id}/">{$textMessage->name}</p>
						<p class="text-med" style="max-width: 80ch;">{$textMessage->description}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{foreachelse}
			-- No text messages have been create yet --
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}

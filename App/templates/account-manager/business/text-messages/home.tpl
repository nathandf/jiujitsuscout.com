{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/campaigns.css">
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Text Messages</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/text-message/new" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Create a Text Message <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear push-b-med"></div>
			{foreach from=$textMessages item=textMessage}
			<div class="push-b-med">
				<a class="link tc-deep-blue" href="{$HOME}account-manager/business/text-message/{$textMessage->id}/">{$textMessage->name}</a>
				<p class="text-med">{$textMessage->description}</p>
			</div>
			{foreachelse}
			-- No text messages have been create yet --
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}

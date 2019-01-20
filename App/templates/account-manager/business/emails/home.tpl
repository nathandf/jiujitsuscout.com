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
			<h2 class="">Emails</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/email/new" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Create an Email <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear push-b-med"></div>
			{foreach from=$emails item=email}
			<a href="{$HOME}account-manager/business/email/{$email->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<p class="text-med-heavy">{$email->name}</p>
					<p class="text-med">{$email->description}</p>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{foreachelse}
			-- No emails have been create yet --
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}

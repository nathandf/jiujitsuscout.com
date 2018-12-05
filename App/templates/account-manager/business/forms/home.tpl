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
			<h2 class="">Forms</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/form/new" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Create a Form <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<p class="text-sml">Create embeddable forms that you can use on your website</p>
			<div class="hr-sml"></div>
			<div class="clear push-b-med"></div>
			{foreach from=$forms item=form}
			<a class="link text-lrg-heavy tc-deep-blue" href="{$HOME}account-manager/business/form/{$form->id}/">{$form->name}</a>
			<div class="clear"></div>
			{foreachelse}
			<p>You haven't made any forms yet</p>
			{/foreach}
		</div>
	</div><!-- end content -->
{/block}

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
			<h2 class="">Sequences</h2>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/sequence/new" class="btn btn-inline mat-hov push-t-med"><span class="text-med">Create a Sequence <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<p class="text-sml">Create automated follow up sequences for your leads and students</p>
		</div>
	</div><!-- end content -->
{/block}

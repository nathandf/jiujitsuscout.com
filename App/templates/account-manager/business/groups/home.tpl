{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg first inner-pad-med">
			<h2 class="first">Groups</h2>
			<p class="text-sml first">Use groups to categorize your leads and members. Get the right message to the right people.</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/group/new" class="btn btn-inline mat-hov first"><span class="text-med">New Group <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear"></div>
			{if $groups}
				{foreach from=$groups item=group name=group_loop}
				<a style="padding-left: 10px; height: 140px; white-space: wrap; overflow: hidden; max-width: 180px" href="{$HOME}account-manager/business/group/{$group->id}/" id="group{$group->id}" class="lead-tag first mat-hov floatleft push-r">
					<div class="lead-data">
						<p class="lead-name">{$group->name|capitalize|truncate:50:"..."}</p>
						<p>{if $group->description}{$group->description|truncate:75:"..."}{else}Description: None{/if}</p>
					</div>
				</a>
				{if $smarty.foreach.group_loop.iteration % 4 == 0}
				<div class="clear first"></div>
				{/if}
				{/foreach}
			{else}
			<p>You havent created any groups yet</p>
			{/if}
			<div class="clear"></div>
		</div>
	</div><!-- end content -->
{/block}

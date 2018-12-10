{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<div class="clear"></div>
		<h2>Groups</h2>
		<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/leads">Leads</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/lead/{$lead->id}/">{$lead->getFullName()}</a> > Groups</p>
		<div class="push-b-med"></div>
		{if $groups}
		<form action="{$HOME}account-manager/business/lead/{$lead->id}/groups" method="post">
			<input type="hidden" name="update_groups">
			{foreach from=$groups item=group}
			<input type="checkbox" id="{$group->name}-cb" class="checkbox" name="group_ids[]" value="{$group->id}" {if $group->isset}checked="checked"{/if}/>
			<a href="{$HOME}account-manager/business/group/{$group->id}/" class="link text-lrg-heavy tc-deep-blue">{$group->name}</a><label> - {$group->description}</label>
			<div class="clear last"></div>
			{/foreach}
			<input class="btn btn-inline first" type="submit" value="Save Groups">
		</form>
		{else}
		<p class="text-sml">You haven't created any groups yet</p>
		<a href="{$HOME}account-manager/business/group/new" class="btn btn-inline mat-hov first"><span class="text-med">Create your first Group <i class="fa fa-plus" aria-hidden="true"></i></span></a>
		{/if}
	</div>
{/block}

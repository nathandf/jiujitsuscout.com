{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<a href="{$HOME}account-manager/business/member/{$member->id}/" class="btn btn-inline text-med bg-dark-mint first">< Member Manager</a>
		<div class="clear first"></div>
		<h2 class="first last">Groups</h2>
		{if $groups}
		<form action="{$HOME}account-manager/business/member/{$member->id}/groups" method="post">
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

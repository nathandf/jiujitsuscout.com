<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xlrg first inner-pad-med">
			<a href="{$HOME}account-manager/business/lead/{$lead->id}/" class="btn btn-inline text-med bg-salmon first">< Lead Manager</a>
			<div class="clear first"></div>
			<h2 class="first last">Groups</h2>
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
  </body>
</html>

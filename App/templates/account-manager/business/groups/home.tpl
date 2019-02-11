{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="">Groups</h2>
			<p class="text-sml">Use groups to categorize your leads and members. Get the right message to the right people.</p>
			{include file="includes/snippets/flash-messages.tpl"}
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/group/new" class="btn btn-inline mat-hov push-t-med"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Group</span></a>
			<div class="clear push-b-med"></div>
			{foreach from=$groups item=group name=group_loop}
			<a href="{$HOME}account-manager/business/group/{$group->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-deep-blue tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-group"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$group->name}</p>
						<p class="text-med" style="max-width: 80ch;">{$group->description}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear push-b-med"></div>
			{foreachelse}
			<p>You havent created any groups yet</p>
			{/foreach}
			<div class="clear"></div>
		</div>
	</div><!-- end content -->
{/block}

{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" href="{$HOME}public/css/leads.css">
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con-cnt-xlrg push-t-med inner-pad-med">
			<h2 class="first">Schedules</h2>
			<p class="text-sml">Create schedules for your programs.</p>
			<div class="hr-sml"></div>
			<div class="clear"></div>
			<a href="{$HOME}account-manager/business/schedule/new" class="btn btn-inline mat-hov push-t-med bg-dark-creamsicle"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Schedule</span></a>
			<div class="clear push-t-med"></div>
			{foreach from=$schedules item=schedule name=schedule_loop}
			<a href="{$HOME}account-manager/business/schedule/{$schedule->id}/" class="tag-link">
				<div class="tag mat-hov cursor-pt">
					<div class="bg-dark-creamsicle tc-white floatleft push-r-sml" style="border-radius: 3px; box-sizing: border-box; padding: 8px;">
						<i aria-hidden="true" class="fa fa-calendar"></i>
					</div>
					<div class="floatleft">
						<p class="text-med-heavy">{$schedule->name|capitalize|truncate:50:"..."}</p>
						<p class="text-med" style="max-width: 80ch;">{if $schedule->description}{$schedule->description|truncate:75:"..."}{else}Description: None{/if}</p>
					</div>
					<div class="clear"></div>
				</div>
			</a>
			<div class="clear first"></div>
			{foreachelse}
			<p>You havent created any schedules yet</p>
			{/foreach}
			<div class="clear"></div>
		</div>
	</div><!-- end content -->
{/block}

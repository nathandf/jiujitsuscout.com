<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" href="{$HOME}public/css/leads.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<h2 class="first">Schedules</h2>
				<p class="text-sml first">Create schedules for your programs.</p>
				<div class="hr-sml"></div>
				<div class="clear"></div>
				<a href="{$HOME}account-manager/business/schedule/new" class="btn btn-inline mat-hov push-t-med bg-dark-creamsicle"><span class="text-med">New Schedule <i class="fa fa-plus" aria-hidden="true"></i></span></a>
				<div class="clear"></div>
				{if $schedules}
					{foreach from=$schedules item=schedule name=schedule_loop}
					<a style="padding-left: 10px; height: 140px; white-space: wrap; overflow: hidden; max-width: 180px" href="{$HOME}account-manager/business/schedule/{$schedule->id}/" id="schedule{$schedule->id}" class="lead-tag first mat-hov floatleft push-r">
						<div class="lead-data">
							<p class="lead-name">{$schedule->name|capitalize|truncate:50:"..."}</p>
							<p>{if $schedule->description}{$schedule->description|truncate:75:"..."}{else}Description: None{/if}</p>
						</div>
					</a>
					{if $smarty.foreach.schedule_loop.iteration % 4 == 0}
					<div class="clear first"></div>
					{/if}
					{/foreach}
				{else}
				<p>You havent created any schedules yet</p>
				{/if}
				<div class="clear"></div>
			</div>
		</div><!-- end content -->
	</body>
</html>

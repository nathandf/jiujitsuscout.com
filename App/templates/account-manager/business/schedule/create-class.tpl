<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<a class="btn btn-inline bg-dark-creamsicle text-med last" href="{$HOME}account-manager/business/schedule/{$current_schedule->id}/">< Schedule</a>
				{if !empty($error_messages.create_class)}
					{foreach from=$error_messages.create_class item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form method="post" action="">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_class" value="{$csrf_token}">
					<div class="clear"></div>
					<p class="text-sml push-t-med">Name: </p>
					<input type="text" name="name" value="{$inputs.create_class.name|default:null}" class="inp field-sml" placeholder="Class name">
					<div class="clear"></div>
					<p class="text-sml push-t-med">Description: </p>
					<div class="clear"></div>
					<textarea style="text-indent: 0px; padding: 8px;" name="description" class="inp field-med" id="" cols="30" rows="10" placeholder="Description of class">{$inputs.create_class.description|default:null}</textarea>
					<div class="clear"></div>
					<p class="text-sml push-t-med">Discipline</p>
					<select name="discipline_id" id="" class="inp field-sml cursor-pt">
					{foreach from=$disciplines item=discipline}
					<option value="{$discipline->id}">{$discipline->name|capitalize}</option>
					{/foreach}
					</select>
					<div class="clear"></div>
					<p class="text-sml push-t-med">Week Day</p>
					<select name="day" id="" class="inp field-sml cursor-pt">
					{foreach from=$weekdays item=weekday}
					<option value="{$weekday}">{$weekday|capitalize}</option>
					{/foreach}
					</select>
					<div class="clear"></div>
					<p class="text-sml push-t-med">Start Time</p>
					{html_select_time class="inp field-xsml cursor-pt" minute_interval=15 display_seconds=false prefix=start_ use_24_hours=false}
					<div class="clear"></div>
					<p class="text-sml push-t-med">End Time</p>
					{html_select_time class="inp field-xsml cursor-pt" minute_interval=15 display_seconds=false prefix=end_ use_24_hours=false}
					<div class="clear"></div>
					<div class="hr-sml push-t-med"></div>
					<p class="text-sml push-b-med">Add to schedules</p>
					{foreach from=$schedules item=schedule}
					<input type="checkbox" name="schedule_ids[]" class="checkbox" {if $current_schedule->id == $schedule->id}checked="checked" {/if}value="{$schedule->id}"><label class="push-l" for="">{$schedule->name|capitalize}</label>
					<div class="clear"></div>
					{/foreach}
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline push-t-med" value="Create class">
				</form>
			</div>
		</div><!-- end content -->
	</body>
</html>

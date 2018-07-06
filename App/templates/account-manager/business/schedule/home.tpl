<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css">
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/schedule.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="clear"></div>
		<div class="con con-cnt-xxlrg first inner-pad-med">
			<a class="btn btn-inline text-med last bg-dark-creamsicle" href="{$HOME}account-manager/business/schedules/">< All Schedules</a>
			<div class="clear push-t-med push-b-med"></div>
			{if !empty($flash_messages)}
				{foreach from=$flash_messages item=message}
					<div class="con-message-success mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<a href="{$HOME}account-manager/business/schedule/{$schedule->id}/edit" class="text-xlrg-heavy tc-deep-blue link">{$schedule->name}</a>
			<p class="text-med first">{$schedule->description}</p>
			<div class="clear hr-sml"></div>
			<a href="{$HOME}account-manager/business/schedule/{$schedule->id}/choose-class" class="btn btn-inline mat-hov push-t-med"><span class="text-med-heavy">Add Class <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear"></div>
			{if $courses}
				<div class="calendar push-t-sml">
					{foreach from=$coursesByDay key=day item=courses}
						{if $courses|@count > 0}
							<div class="calendar-row"></div>
							<div class="weekday-header">{$day|capitalize}</div>
							<div class="clear calendar-row"></div>
							{foreach from=$courses item=course}
							<div class="course-checkbox-container">
								<div class="course-container">
									<div class="course floatleft">
										<form method="post" action="">
											<input type="hidden" name="token" value="{$csrf_token}">
											<input type="hidden" name="remove_course" value="{$csrf_token}">
											<input type="hidden" name="course_id" value="{$course->id}">
											<button class="floatright tc-y-red text-med-heavy cursor-pt" style="background: none;">x</button>
										</form>
										<div class="course-name">
											<p class="text-med-heavy">{$course->name|truncate:35:"..."}</p>
										</div>
										<div class="hr-std"></div>
										<div class="course-time">
											<p class="text-sml-heavy push-t-sml">{$course->start_time} - {$course->end_time}</p>
										</div>
									</div>
								</div>
							</div>
							{/foreach}
						{/if}
						<div class="clear clendar-row"></div>
					{/foreach}
				</div>
			<div class="clear"></div>
			{else}
				<p class="text-med">No classes have been added to this schedule yet</p>
			{/if}
		<div>
	</body>
</html>

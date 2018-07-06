<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css"/>
		<link rel="stylesheet" type="text/css" href="{$HOME}css/schedule.css"/>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}schedule.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg first inner-pad-med">
			<a class="btn btn-inline text-med push-b-med bg-dark-creamsicle" href="{$HOME}account-manager/business/schedule/{$schedule->id}/">< Schedule</a>
			<p class="text-sml">Choose a class to add to the schedule or create a new one</p>
			<div class="hr-sml"></div>
			<a class="btn btn-inline push-t-med" href="{$HOME}account-manager/business/schedule/{$schedule->id}/create-class">New class +</a>
			<div class="clear"></div>
			{if $courses|@count < 1}
			<p class="text-sml push-t-med">No classes available to add to this schedule</p>
			{else}
				<h2>All Classes</h2>
				<div class="calendar push-t-med">
					<form method="post" action="">
						<button type="submit" id="add-classes-button" class="btn btn-inline-disabled push-t-med push-l-med push-b-med" disabled>Add Classes +</button>
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="add_class" value="{$csrf_token}">
						<div id="courses-container">
						{foreach from=$coursesByDay key=day item=courses}
							{if $courses|@count > 0}
								<div class="calendar-row"></div>
								<div class="weekday-header">{$day|capitalize}</div>
								<div class="clear calendar-row"></div>
								{foreach from=$courses item=course}
								<div class="course-checkbox-container">
									<input type="checkbox" id="class{$course->id}" class="course-checkbox" name="course_ids[]" value="{$course->id}">
									<div class="course-container">
										<label for="class{$course->id}" class="course-label">
											<div class="course floatleft mat-hov cursor-pt">
												<p class="text-med-heavy">{$course->name|truncate:35:"..."}</p>
												<p class="text-sml-heavy push-t-sml">{$course->start_time} - {$course->end_time}</p>
											</div>
										</label>
									</div>
								</div>
								{/foreach}
							{/if}
							<div class="clear clendar-row"></div>
						{/foreach}
						</div>
					</form>
				</div>
			<div class="clear"></div>
			{/if}
		</div>
  </body>
</html>

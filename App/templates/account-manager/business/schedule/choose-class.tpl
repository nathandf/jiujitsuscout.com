{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css"/>
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/schedule.css"/>
	<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}schedule.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<a class="btn btn-inline text-med push-b-med bg-dark-creamsicle" href="{$HOME}account-manager/business/schedule/{$schedule->id}/">< Schedule</a>
		<h2>Choose classes</h2>
		<p class="text-sml">Choose a class to add to the schedule or create a new one</p>
		<div class="hr-sml"></div>
		<div class="clear"></div>
		{if $courses|@count < 1}
		<p class="text-sml push-t-med">No classes available to add to this schedule</p>
		{else}

			<div class="calendar push-t-med">
				<a class="btn btn-inline push-t-med push-l-med floatleft" href="{$HOME}account-manager/business/schedule/{$schedule->id}/create-class">New class +</a>
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
{/block}

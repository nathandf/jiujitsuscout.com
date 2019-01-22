{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg encapsulate bg-white first">
		<div class="bg-lavender">
			<div class="col col-2"><p class="col-title tc-white">Total Appts.</p></div>
			<div class="col col-2-last"><p class="col-title tc-white">Appts. Passed</p></div>
			<div class="clear"></div>
		</div>
		<div class="row-seperator"></div>
		<div class="col col-2"><p class="col-title">--</p></div>
		<div class="col col-2-last"><p class="col-title">--</p></div>
		<div class="clear"></div>
	</div>
	<div class="con-cnt-xxlrg inner-pad-med">
		<div class="con-cnt-xxlrg">
		<h2>Appointments</h2>
		<a href="{$HOME}account-manager/business/appointment/new" class="btn btn-inline appointments mat-hov first"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Appointment</span></a>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med first last" placeholder="Search">
		<div class="clear"></div> -->
		<div id="lead-tag-container">
			<p class='results_count_message'>Showing ({$appointments_total}) Appointments</p>
			{foreach from=$appointments_by_time.past item=appointment name=past}
				{if $smarty.foreach.past.index == 0}
					<h3 class="first">Passed</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-2"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$appointments_by_time.today item=appointment name=today}
				{if $smarty.foreach.today.index == 0}
					<h3 class="first">Today</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-4"><i class="fa fa-clock-o"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$appointments_by_time.tomorrow item=appointment name=tomorrow}
				{if $smarty.foreach.tomorrow.index == 0}
					<h3 class="first">Tomorrow</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-3"><i class="fa fa-clock-o"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$appointments_by_time.this_week item=appointment name=this_week}
				{if $smarty.foreach.this_week.index == 0}
					<h3 class="first">This Week</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-1"><i class="fa fa-clock-o"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$appointments_by_time.next_week item=appointment name=next_week}
				{if $smarty.foreach.next_week.index == 0}
					<h3 class="first">Next Week</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-1"><i class="fa fa-clock-o"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$appointments_by_time.upcoming item=appointment name=upcoming}
				{if $smarty.foreach.upcoming.index == 0}
					<h3 class="first">Upcoming</h3>
				{/if}
				<a href="{$HOME}account-manager/business/appointment/{$appointment->id}/" id="appointment{$appointment->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-1"><i class="fa fa-clock-o"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$appointment->prospect->first_name} {$appointment->prospect->last_name}</p>
						<p>{$appointment->appointment_time|date_format:"%a, %b %e %Y"}</p>
						<p>{$appointment->appointment_time|date_format:"%l:%M%p"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
{/block}

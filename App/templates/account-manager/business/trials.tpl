{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg first inner-pad-med">
		<h2>Trials</h2>
		<a href="{$HOME}account-manager/business/trial/new" class="btn btn-inline trials first mat-hov"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Trial</span></a>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med first last" placeholder="Search">
		<div class="clear"></div> -->
		<div id="lead-tag-container">
			<p class='results_count_message'>Showing ({$trials|@count}) Results</p>
			{foreach from=$trials_by_time.past item=trial name=past}
				{if $smarty.foreach.past.index == 0}
					<h3 class="first">Trial Ended</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon icon-c-2"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.today item=trial name=today}
				{if $smarty.foreach.today.index == 0}
					<h3 class="first">Today</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.tomorrow item=trial name=tomorrow}
				{if $smarty.foreach.tomorrow.index == 0}
					<h3 class="first">Tomorrow</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.this_week item=trial name=this_week}
				{if $smarty.foreach.this_week.index == 0}
					<h3 class="first">This Week</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.next_week item=trial name=next_week}
				{if $smarty.foreach.next_week.index == 0}
					<h3 class="first">Next Week</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.upcoming item=trial name=upcoming}
				{if $smarty.foreach.upcoming.index == 0}
					<h3 class="first">Upcoming</h3>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}" class="lead-tag first mat-hov">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
						<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
						<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
{/block}

{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<h2>Trials</h2>
		<a href="{$HOME}account-manager/business/trial/new" class="btn btn-inline trials first mat-hov"><i class="fa fa-plus push-r-sml" aria-hidden="true"></i><span class="text-med">New Trial</span></a>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med first last" placeholder="Search">
		<div class="clear"></div> -->
		<div id="lead-tag-container">
			<p class='results_count_message push-b-med'>Showing ({$trials|@count}) Results</p>
			{foreach from=$trials_by_time.past item=trial name=past}
				{if $smarty.foreach.past.index == 0}
					<p class="label">Trial Ended</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.today item=trial name=today}
				{if $smarty.foreach.today.index == 0}
					<p class="label">Today</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.tomorrow item=trial name=tomorrow}
				{if $smarty.foreach.tomorrow.index == 0}
					<p class="label">Tomorrow</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.this_week item=trial name=this_week}
				{if $smarty.foreach.this_week.index == 0}
					<p class="label">This Week</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.next_week item=trial name=next_week}
				{if $smarty.foreach.next_week.index == 0}
					<p class="label">Next Week</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
			{foreach from=$trials_by_time.upcoming item=trial name=upcoming}
				{if $smarty.foreach.upcoming.index == 0}
					<p class="label">Upcoming</p>
				{/if}
				<a href="{$HOME}account-manager/business/lead/{$trial->id}/trial" id="lead{$trial->id}">
					<div class="tag push-b-med mat-hov">
						<div class="lead-icon-container floatleft">
							<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$trial->first_name|substr:0:1|upper}</span>
						</div>
						<div class="lead-data floatleft">
							<p class="lead-name">{$trial->first_name} {$trial->last_name}</p>
							<p>Start: {$trial->trial_start|date_format:"%a, %b %e %Y"}</p>
							<p>End: {$trial->trial_end|date_format:"%a, %b %e %Y"}</p>
						</div>
						<div class="clear"></div>
					</div>
				</a>
				<div class="clear"></div>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
{/block}

{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/leads.css"/>
	<script src="{$HOME}public/js/trial-details.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg first inner-pad-med">
		{if !empty($error_messages.add_trial)}
			{foreach from=$error_messages.add_trial item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<h2>{$prospect->first_name|capitalize} {$prospect->last_name|capitalize}</h2>
		<p class="push-t-lrg label">Start Date</p>
		<form method="get" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="add_trial" value="{$csrf_token}">
			<input type="hidden" name="prospect_id" value="{$prospect->id}">
			{html_select_date class="inp inp-sml cursor-pt push-b-med" prefix='StartDate' start_year='-1' end_year='+3'}
			<div class="clear"></div>
			<input id="specific-end-date-select" class="cursor-pt push-b-med push-t-med" type="checkbox" name="specific_end_date" value="true"> <label for="specific-end-date">Set specific end date</label>
			<div id="trial-length" style="display: block;" class="trial-length">
				<p class="label">Trial Length</p>
				<input id="quantity" type="quantity" class="inp inp-sml push-b-med" name="quantity" placeholder="Ex. 6"> <label for="quantity">Qty.</label>
				<select class="inp inp-sml push-b-med cursor-pt" name="unit" id="unit">
					<option value="week" selected="selected" hidden="hidden">Week(s)</option>
					<option id="day" value="day">Day(s)</option>
					<option id="week" value="week">Week(s)</option>
					<option id="month" value="month">Month(s)</option>
				</select>
			</div>
			<div id="specific-end-date" style="display: none;" class="end-date">
				<p class="label">End Date</p>
				{html_select_date class="inp inp-sml cursor-pt push-b-med" prefix='EndDate' start_year='-1' end_year='+3'}
				</select>
			</div>
			<input type="submit" class="btn bnt-inline push-t-med" value="Create Trial">
		</form>
	</div>
{/block}

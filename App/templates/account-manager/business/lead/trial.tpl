{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<a href="{$HOME}account-manager/business/lead/{$lead->id}/" class="btn btn-inline bg-salmon text-med push-t-med">< Lead Manager</a>
		<a href="{$HOME}account-manager/business/trials" class="btn btn-inline bg-mango text-med push-t-med floatright">All Trials ></a>
		<div class="clear"></div>
		<p class="text-lrg-heavy push-t-med push-b">{$lead->first_name|default:null}{if $lead->last_name} {$lead->last_name}{/if}</p>
		<div class="con-cnt-xxlrg encapsulate bg-white">
			<div class="bg-mango">
				<div class="col col-2"><p class="col-title tc-white">Trial Start</p></div>
				<div class="col col-2-last"><p class="col-title tc-white">Trial End</p></div>
				<div class="clear"></div>
			</div>
			<div class="row-seperator"></div>
			<div class="col col-2"><p class="col-title">{$lead->trial_start|date_format:"%a, %b %e %Y"}</p></div>
			<div class="col col-2-last"><p class="col-title">{$lead->trial_end|date_format:"%a, %b %e %Y"}</p></div>
			<div class="clear"></div>
		</div>
		<div id="trial-length" style="display: block;" class="trial-length">
			{if !empty($error_messages.update_trial)}
				{foreach from=$error_messages.update_trial item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="encapsulate inner-pad-med bg-white" style="display: table;">
				<p class="text-med-heavy">Extend trial by:</p>
				<form method="post" action="{$HOME}account-manager/business/lead/{$lead->id}/trial">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input id="quantity" type="number" class="inp field-sml" name="quantity" placeholder="Ex. 6"> <label for="quantity">Qty.</label>
					<select class="inp field-sml cursor-pt" name="unit" id="unit">
						<option value="week" selected="selected" hidden="hidden">Week(s)</option>
						<option id="day" value="day">Day(s)</option>
						<option id="week" value="week">Week(s)</option>
						<option id="month" value="month">Month(s)</option>
					</select>
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline push-t-med" value="Extend Trial">
				</form>
			</div>
		</div>
	</div>
{/block}

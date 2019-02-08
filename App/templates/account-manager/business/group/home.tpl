{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div class="clear"></div>
	<div class="con con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/groups/">< All Groups</a>
		<div class="clear push-t-med"></div>
		<a href="{$HOME}account-manager/business/group/{$group->id}/edit" class="text-xlrg-heavy tc-deep-blue link">{$group->name}</a>
		<p class="text-sml">{$group->description}</p>
		{include file="includes/snippets/flash-messages.tpl"}
		<div class="hr-sml push-b-med"></div>
		<a href="{$HOME}account-manager/business/group/{$group->id}/choose-prospect" class="btn btn-inline bg-salmon text-med"><i aria-hidden="true" class="fa fa-plus push-r-sml"></i> Lead</a>
		<a href="{$HOME}account-manager/business/group/{$group->id}/choose-member" class="btn btn-inline bg-dark-mint text-med"><i aria-hidden="true" class="fa fa-plus push-r-sml"></i> Member</a>
		<div class="clear"></div>
		{if $leads|@count > 0}
			<h3>Leads</h3>
			<div class="clear"></div>
			{foreach from=$leads item=lead}
			<a href="{$HOME}account-manager/business/lead/{$lead->id}/" id="lead{$lead->id}" class="tag push-t-med mat-hov">
				<div class="lead-icon-container floatleft">
				{if $lead->type == "trial"}
					<span class="lead-icon icon-c-3"><i class="fa fa-calendar" aria-hidden="true"></i></span>
				{elseif $lead->type == "lead"}
					{if $lead->times_contacted < 1}
					<span class="lead-icon icon-c-2"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
					{else}
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$lead->first_name|substr:0:1|upper}</span>
					{/if}
				{elseif $lead->type == "member"}
					<span class="lead-icon bg-dark-mint"><i class="fa fa-user" aria-hidden="true"></i></span>
				{/if}
				</div>
				<div class="lead-data floatleft">
					<p class="lead-name">{$lead->first_name|capitalize|truncate:20:"..."} {$lead->last_name|capitalize|truncate:20:"..."}</p>
					<p>{$lead->phone_number|default:"Number: N/a"}</p>
					<p>{if $lead->email}{$lead->email|lower|truncate:20:"..."}{else}email: N/a{/if}</p>
				</div>
				<div class="clear"></div>
			</a>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="prospect_id" value="{$lead->id}">
				<input type="hidden" name="remove_prospect" value="{$csrf_token}">
				<button type="submit" style="background: none;" class="push-t push-l cursor-pt"><span class="text-sml tc-salmon">remove</span></button>
			</form>
			<div class="clear"></div>
			{/foreach}
			<div class="hr"></div>
		{/if}
		{if $members|@count > 0}
		<div class="clear push-t-med"></div>

		<h3>Members</h3>
			<div class="clear"></div>
			{foreach from=$members item=member}
			<a href="{$HOME}account-manager/business/member/{$member->id}/" id="member{$member->id}" class="tag push-t-med mat-hov">
				<div class="lead-icon-container floatleft">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$member->first_name|substr:0:1|upper}</span>
				</div>
				<div class="lead-data floatleft">
					<p class="lead-name">{$member->first_name|capitalize|truncate:20:"..."} {$member->last_name|capitalize|truncate:20:"..."}</p>
					<p>{$member->phone_number|default:"Number: N/a"}</p>
					<p>{if $member->email}{$member->email|lower|truncate:20:"..."}{else}email: N/a{/if}</p>
				</div>
				<div class="clear"></div>
			</a>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="member_id" value="{$member->id}">
				<input type="hidden" name="remove_member" value="{$csrf_token}">
				<button type="submit" style="background: none;" class="push-t push-l cursor-pt"><span class="text-sml tc-salmon">remove</span></button>
			</form>
			<div class="clear"></div>
			{/foreach}
			<div class="hr"></div>
		{/if}
		<div class="clear"></div>
	</div>
{/block}

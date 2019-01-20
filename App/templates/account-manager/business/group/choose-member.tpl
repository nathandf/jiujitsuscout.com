{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}

{/block}

{block name="bm-body"}
	{include file="includes/navigation/communication-sub-menu.tpl"}
	<div class="con-cnt-xxlrg first inner-pad-med">
		<h3>Choose a Member</h3>
		<span>or <a class="link" href="{$HOME}account-manager/business/member/new">create a new one</a></span>
		<div class="clear"></div>
		<!-- <input type="search" class="inp field-med first last" placeholder="Search">
		<div class="clear"></div> -->
		{if $members|@count < 1}
		<p class="text-sml first">No members available to add to this group</p>
		{/if}
		{foreach from=$members item=member}
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="member_id" value="{$member->id}">
				<button class="lead-tag first mat-hov cursor-pt">
					<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$member->first_name|substr:0:1|upper}</span>
					<div class="lead-data">
						<p class="lead-name">{$member->first_name|capitalize|truncate:20:"..."} {$member->last_name|capitalize|truncate:20:"..."}</p>
						<p>{$member->phone_number}</p>
						<p>{$member->email|lower|truncate:20:"..."}</p>
					</div>
				</button>
			</form>
			<div class="clear"></div>
		{/foreach}
	</div>
{/block}

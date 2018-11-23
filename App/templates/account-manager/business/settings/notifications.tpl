{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-box push-t-med bg-white">
		{include file="includes/navigation/business-manager-settings-menu.tpl"}
		<div class="clear"></div>
		<div class="con-cnt-xlrg inner-pad-med">
			<div class="hr">
				<p class="txt-sml">Select which users you would like to recieve lead capture notifications</p>
			</div>
			{if !empty($error_messages.update_users)}
				{foreach from=$error_messages.update_users item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="" id="users" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_user_ids" value="{$csrf_token}">
				{foreach from=$users item=user}
					<input type="checkbox" id="{$user->id}-cb" class="checkbox" name="user_ids[]" value="{$user->id}" {if $user->isset}checked="checked"{/if}/><label for="{$user->id}-cb"> {$user->first_name} {$user->last_name} : {$user->role|ucfirst}</label>
					<div class="clear last"></div>
				{/foreach}
				<div class="clear"></div>
				<input type="submit" class="btn" name="update-users" value="Update Notification List">
				<div class="clear"></div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}

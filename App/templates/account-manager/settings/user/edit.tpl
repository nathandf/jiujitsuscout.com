{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	 <link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
{/block}

{block name="am-body"}
	{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="con-cnt-xxlrg bg-white mat-box-shadow push-t-med push-b-lrg">
		{include file="includes/navigation/account-manager-settings-menu.tpl"}
		<div class="inner-pad-med">
			<h2 class="h2 push-b push-t">Edit user details</h2>
			{include file="includes/snippets/flash-messages.tpl"}
			{if !empty($error_messages.edit_user)}
				{foreach from=$error_messages.edit_user item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{if !empty($error_messages.delete_user)}
				{foreach from=$error_messages.delete_user item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="push-t-med"></div>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_user" value="{$csrf_token}">
				<div class="clear push-t-med"></div>
				<label class="text-sml">First name</label><br>
				<input type="text" class="inp inp-med-plus-plus" name="first_name" value="{$user_to_edit->first_name}">
				<div class="clear"></div>
				<div class="clear push-t-med"></div>
				<label class="text-sml">Last name</label><br>
				<input type="text" class="inp inp-med-plus-plus" name="last_name" value="{$user_to_edit->last_name}">
				<div class="clear"></div>
				<div class="clear push-t-med"></div>
				<label class="text-sml">Email</label><br>
				<input type="text" class="inp inp-med-plus-plus" name="email" value="{$user_to_edit->email}">
				<div class="clear"></div>
				<div class="clear push-t-med"></div>
				<label class="text-sml">Country Code</label><br>
				<select class="inp inp-sml cursor-pt" id="country_code" name="country_code"/>
					{if $phone->country_code != null}
					<option selected="selected" value="{$phone->country_code}">+{$phone->country_code}</option>
					{else}
					<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
					{/if}
					{if isset($country_code)}
					<option value="">-- Default Country Code --</option>
					<option value="{$country_code}">+{$country_code}</option>
					{/if}
					<option value="">-- Common Country Codes --</option>
					<option value="1">USA +1</option>
					<option value="1">CAN +1</option>
					<option value="44">UK +44</option>
					<option value="61">AUS +61</option>
					<option value="">-- All Country Codes --</option>
					{foreach from=$countries item=country}
					<option value="{$country->phonecode}">{if $country->iso3}{$country->iso3}{else}{$country->iso}{/if} +{$country->phonecode}</option>
					{/foreach}
				</select>
				<div class="clear push-t-med"></div>
				<label class="text-sml">Phone number</label>
				<div class="clear"></div>
				<input type="text" class="inp inp-med-plus-plus" name="phone_number" value="{$phone->national_number|default:null}">
				<div class="clear push-t-med"></div>
				<label class="text-sml">Role</label>
				<div class="clear"></div>
				<select class="inp inp-sml cursor-pt" id="role" name="role"/>
					<option value="{$user_to_edit->role}" selected="selected" hidden="hidden">{$user_to_edit->role|capitalize}</option>
					{foreach from=$roles item=role}
					<option value="{$role}">{$role|capitalize}</option>
					{/foreach}
				</select>
				<div class="clear"></div>
				<button type="submit" class="btn btn-inline push-t-med floatleft">Update</button>
			</form>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="delete_user" value="{$csrf_token}">
				<button type="submit" class="btn btn-inline push-t-med bg-red tc-white floatright --c-trash" name="delete_user" value="true"><i aria-hidden="true" class="fa fa-trash push-r-sml"></i>Delete User</button>
			</form>
			<div class="clear"></div>
		</div>
	</div>
{/block}
